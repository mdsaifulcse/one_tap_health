<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Models\HospitalWiseTestPrice;
use App\Models\Patient;
use App\Models\TestOrder;
use App\Models\TestOrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\ApiResponseTrait;
use DB,Validator,Auth;

class TestOrderController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderNo=$this->generateOrderInvoiceNo();
        $request['order_no']=$orderNo;
        $rules=$this->testOrderValidationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

//        if (count(array_unique($request->hospital_id))>1){
//            return $this->respondWithValidation('Validation Fail',"select test from same hospital at a tiem",Response::HTTP_BAD_REQUEST);
//        }

        DB::beginTransaction();
        try{
            // generate patient id
            if ($request->order_for_other_patient==0){
                $request['patient_name']=auth()->user()->name;
                $request['patient_mobile']=auth()->user()->phone;
                $request['patient_age']=auth()->user()->address;
                $request['patient_address']=auth()->user()->address;

                $patientId=$this->storeNewPatient($request)->id;
            }else{ // for new patient ------------
                $patientId=$this->storeNewPatient($request)->id;
            }

            $testOrder=TestOrder::create(
                [
                 'order_no'=>$orderNo,
                 'refer_by_id'=>$request->refer_by_id??\Auth::user()->id,
                 'hospital_id' => $request->hospital_id,
                 'patient_id' => $patientId,
                 'test_date'=>date('Y-m-d',strtotime($request->test_date)),
                 'discount'=>$request->discount??0,
                 'service_charge'=>$request->service_charge??0,
                 'amount'=>$this->calculateTestOrderAmount($request)['amount']??0,
                 'total_amount'=>$this->calculateTestOrderAmount($request)['total_amount']??0,
                 'reconciliation_amount'=>$this->calculateTestOrderAmount($request)['total_amount']??0,
                 'note' => $request->note??'',
                 'source' => TestOrder::SOURCEMOBILE,
                 'created_by' => \Auth::user()->id,
                ]);

           $saveStatus= $this->saveTestOrderDetails($request,$testOrder->id); //result true Or false
           if ($saveStatus==false){
               DB::rollback();
               Log::info('Test order details did not save');
               return $this->respondWithError('Hospital wise test price not found',[],Response::HTTP_NOT_FOUND);
           }

            DB::commit();
            Log::info('Test order Place from api');
            return $this->respondWithSuccess('Order has been Placed successful',['order_no'=>$testOrder->order_no],Response::HTTP_OK);

        }catch(Exception $e){
            DB::rollback();
            Log::info('Test order error api: '.$e->getMessage());
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function testOrderValidationRules($request){
        $rules=[
            'order_for_other_patient' => 'required|numeric|in:0,1',
            'order_no' => 'unique:test_orders,order_no,NULL,id,deleted_at,NULL',
            'patient_name'  => 'required_if:order_for_other_patient,==,1|max:100',
            'patient_age'  => 'required_if:order_for_other_patient,==,1|max:50',
            'patient_address'  => 'required_if:order_for_other_patient,==,1|max:150',
            'patient_mobile'  => "nullable|max:15",
            'patient_email'  => "nullable|max:15",

            'test_date'  => "required|date",
            'discount'  => "numeric|numeric|digits_between:1,99999|max:9999",
            'service_charge'  => "numeric|digits_between:1,6",

            "test_id"   => "required|array|min:1",
            'test_id.*' => "exists:tests,id",

            'hospital_id' => "exists:hospitals,id",
            //"hospital_id"   => "required|array|min:1",
        ];
        return $rules;
    }

    public function storeNewPatient($request){

        $patient=Patient::where(function ($query)use($request){
            $query->where('mobile',$request->patient_mobile)
                ->where('name','like', '%'.$request->patient_name.'%');
                //->orWhere('address','like', '%'.$request->patient_address.'%');
        })->first();

        if ($patient){
            return $patient;
        }else{
           return $patient= Patient::create([
                'patient_no'=>Patient::generatePatientId(),
                'name'=>$request->patient_name,
                'age'=>$request->patient_age??18,
                'mobile'=>$request->patient_mobile,
                'address'=>$request->patient_address,
            ]);
        }


    }

    public function generateOrderInvoiceNo(){

        $lastOrderNo=TestOrder::max('order_no');
        if (empty($lastOrderNo)){
            $lastOrderNo=1;
        }else{
            $lastOrderNo+=1;
        }

        $invoiceLength= env('INVOICE_LENGTH',TestOrder::INVOICENOLENGTH);
        return str_pad($lastOrderNo,$invoiceLength,"0",false);
    }

    public function calculateTestOrderAmount($request){

        $amount=0;
        $totalAmount=0;
        foreach ($request->test_id as $key=>$item){
            $hospitalTestPrice=HospitalWiseTestPrice::where(['test_id'=>$request->test_id[$key],'hospital_id'=>$request->hospital_id])->first();

            if($hospitalTestPrice) {
                // actual test price after discount -----
                $testPrice=$hospitalTestPrice->price-$hospitalTestPrice->discount;
                $amount+=$testPrice;
            }
        }


        $totalAmount=$amount;
        if ($request->has('discount') && $request->filled('discount')){
            // deduct discount from amount -----
            $totalAmount= $amount-$request->discount;
        }

        if ($request->has('service_charge') && $request->filled('service_charge')){
            // add service_charge to amount
            $totalAmount=$totalAmount+$request->service_charge;
        }

        return ['amount'=>$amount,'total_amount'=>$totalAmount];
    }

    public function saveTestOrderDetails($request,$testOrderId ){

        $testOrderDetails=[];
        foreach ($request->test_id as $key=>$item){

            $hospitalTestPrice=HospitalWiseTestPrice::where(['test_id'=>$request->test_id[$key],'hospital_id'=>$request->hospital_id])->first();
            if($hospitalTestPrice) {
               // $testPrice=$hospitalTestPrice->price-$hospitalTestPrice->discount;
                $testOrderDetails[] = [
                    'test_order_id' => $testOrderId,
                    'test_id' => $request->test_id[$key],
                    'hospital_id' => $request->hospital_id,
                    'price' => $hospitalTestPrice->price,
                    'discount' => $hospitalTestPrice->discount,
                    'created_by' => \Auth::user()->id,
                ];
            }
        }

        if (count($testOrderDetails)>0){
            TestOrderDetail::insert($testOrderDetails);
            return true;
        }else{
            return false;
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestOrder  $testOrder
     * @return \Illuminate\Http\Response
     */
    public function show(TestOrder $testOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestOrder  $testOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(TestOrder $testOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestOrder  $testOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestOrder $testOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestOrder  $testOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestOrder $testOrder)
    {
        //
    }
}
