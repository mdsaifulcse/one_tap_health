<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalWiseTestPrice;
use App\Models\TestOrder;
use App\Models\TestOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator,MyHelper,DB,Yajra\DataTables\DataTables;

class TestOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {
            $allData=TestOrder::with('hospital');

            return  DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('hospitals_name',function (TestOrder $testOrder){
                    return $testOrder->hospital->name;
                })
                ->addColumn('test_date','
                    {{date(\'M-d-Y\',strtotime($test_date))}}
                ')
                ->addColumn('visit_status','
                     @if($visit_status==\App\Models\TestOrder::YES)
                        <button class="btn btn-success btn-sm">Yes</button>
                            @else
                            <button class="btn btn-warning btn-sm">No</button>
                        @endif
                ')
                ->addColumn('payment_status','
                     @if($payment_status==\App\Models\TestOrder::PARTIALPAYMENT)
                        <button class="btn btn-warning btn-sm">Partial</button>
                        
                        @elseif($payment_status==\App\Models\TestOrder::FULLPAYMENT)
                        <button class="btn btn-success btn-sm">Full</button>
                            @else
                            <button class="btn btn-danger btn-sm">Due</button>
                        @endif
                ')
                ->addColumn('created_at','
                    {{date(\'M-d-Y\',strtotime($created_at))}}
                ')
                ->addColumn('control','
                    <span class=\'dropdown\'>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" onclick="showTestOrderDetailsModal({{$id}})" class="btn btn-success btn-sm" title="Click here for order details">Details <i class="icofont icofont-eye"></i> </a></li>
                            <li>
                                {{--{!! Form::open(array(\'route\' => [\'admin.test-orders.destroy\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}
                                <button type="button" class="btn btn-danger btn-sm" onclick=\'return deleteConfirm("deleteForm{{$id}}")\'>Delete <i class="icofont icofont-trash"></i></button>
                                {!! Form::close() !!}--}}
                            </li>
                        </ul>
                    </span>
                ')
                ->rawColumns(['hospitals_name','test_date','visit_status','payment_status','created_at','control'])
                ->toJson();
        }

        return view('admin.test-orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lastOrderNo=$this->generateOrderInvoiceNo();
        return view('admin.test-orders.create',compact('lastOrderNo'));
    }

    public function createTestOrderDetails($hospitalId){
        $hospitalWiseTests=HospitalWiseTestPrice::with('test')->where(['hospital_id'=>$hospitalId])->get();
        return view('admin.test-orders.load-hospital-wise-test-details',compact('hospitalWiseTests'));
    }


    public function store(Request $request)
    {
        $orderNo=$this->generateOrderInvoiceNo();
        $request['order_no']=$orderNo;
        $rules=$this->testOrderValidationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }

//        if (count(array_unique($request->hospital_id))>1){
//            return $this->respondWithValidation('Validation Fail',"select test from same hospital at a tiem",Response::HTTP_BAD_REQUEST);
//        }

        DB::beginTransaction();
        try{
            $testOrder=TestOrder::create(
                [
                    'order_no'=>$orderNo,
                    'user_id'=>\Auth::user()->id,
                    'hospital_id' => $request->hospital_id,
                    'patient_name'=>$request->patient_name,
                    'patient_mobile'=>$request->patient_mobile,
                    'patient_address'=>$request->patient_address,
                    'test_date'=>date('Y-m-d',strtotime($request->test_date)),
                    'discount'=>$request->discount??0,
                    'service_charge'=>$request->service_charge??0,
                    'amount'=>$this->calculateTestOrderAmount($request)['amount']??0,
                    'total_amount'=>$this->calculateTestOrderAmount($request)['total_amount']??0,
                    'reconciliation_amount'=>$this->calculateTestOrderAmount($request)['total_amount']??0,
                    'note' => $request->note??'',
                    'source' => TestOrder::SOURCEADMIN,
                    'created_by' => \Auth::user()->id,
                ]);

            $saveStatus= $this->saveTestOrderDetails($request,$testOrder->id); //result true Or false
            if ($saveStatus==false){
                DB::rollback();
                Log::info('Test order details did not save');
                return redirect()->back()->with('error','Hospital wise test price not found');
            }

            Log::info('Test order Place from web (admin)');
            DB::commit();
            return redirect()->back()->with('success','Order has been Placed successful');

        }catch(\Exception $e){
            DB::rollback();
            Log::info('Test order error web admin: '.$e->getMessage());
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    public function testOrderValidationRules($request){
        $rules=[
            'order_no' => 'unique:test_orders,order_no,NULL,id,deleted_at,NULL',
            'patient_name'  => "required|max:100",
            'patient_mobile'  => "required|max:15",
            'patient_address'  => "required|max:150",
            'test_date'  => "required|date",
            'amount'  => "numeric|numeric|digits_between:1,9999999|min:1|max:9999999",
            'discount'  => "numeric|numeric|digits_between:1,99999|max:9999",
            'service_charge'  => "numeric|digits_between:1,6",

            "test_id"   => "required|array|min:1",
            'test_id.*' => "exists:tests,id",

            'hospital_id' => "exists:hospitals,id",
            //"hospital_id"   => "required|array|min:1",
        ];
        return $rules;
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
                $testPrice=$hospitalTestPrice->price-$hospitalTestPrice->discount;
                $testOrderDetails[] = [
                    'test_order_id' => $testOrderId,
                    'test_id' => $request->test_id[$key],
                    'hospital_id' => $request->hospital_id,
                    'price' => $testPrice,
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
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(TestOrder $testOrder)
    {
         $testOrder->load(['testOrderDetails:id,test_order_id,test_id,price,approval_status,delivery_status,delivery_date','testOrderDetails.test:id,title','hospital:id,name,branch,address1']);
        return view('admin.test-orders.show',compact('testOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit(Hospital $hospital)
    {
        $data=$hospital;
        $maxSerial=Hospital::max('sequence');
        return view('admin.test-orders.edit',compact('data','maxSerial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        $input = $request->all();
        $id=$hospital->id;

        $validator = Validator::make($input, [
            'name' => 'required|max: 180',
            'address1' => 'required|max: 240',
            'branch' => "required|unique:hospitals,branch,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('photo')) {
                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/hospital/',250,155);

                if($hospital->photo!=null and file_exists($hospital->photo)){
                    unlink($hospital->photo);
                }
            }
            $hospital->update($input);
            return redirect()->back()->with('success','Hospital Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        try{
            // Delete old test price data -------
            $hospitalWiseTestPrice=HospitalWiseTestPrice::where(['hospital_id'=>$hospital->id])->first();
            if (!empty($hospitalWiseTestPrice)){
                HospitalWiseTestPrice::where(['hospital_id'=>$hospital->id])->delete();
            }

            $hospital->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }
}
