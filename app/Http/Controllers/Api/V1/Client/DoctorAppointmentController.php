<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Models\DoctorAppointment;
use App\Models\DoctorAppointmentDetail;
use App\Models\HospitalWiseDoctorSchedule;
use App\Models\HospitalWiseTestPrice;
use App\Models\Patient;
use App\Models\TestOrder;
use App\Models\TestOrderDetail;
use App\Models\TestOrderPaymentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\ApiResponseTrait;
use DB,Validator,Auth;

class DoctorAppointmentController extends Controller
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
        $appointmentNo=DoctorAppointment::generateAppointmentInvoiceNo();
        $request['appointment_no']=$appointmentNo;
        $rules=$this->validationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        $appointmentDay=strtolower(date('l',strtotime($request->appointment_date)));

        $hospitalWiseDoctorSchedule=HospitalWiseDoctorSchedule::where(['status'=>HospitalWiseDoctorSchedule::ACTIVE])->findOrFail($request->schedule_id);
        $availableDay=json_decode($hospitalWiseDoctorSchedule->available_day);

         if (!in_array($appointmentDay,$availableDay)) {
            return $this->respondWithValidation('Validation Fail',"Appointment date must be according to $hospitalWiseDoctorSchedule->doctorAvailableDay",Response::HTTP_BAD_REQUEST);
        }

//        if (count(array_unique($request->hospital_id))>1){
//            return $this->respondWithValidation('Validation Fail',"select test from same hospital at a tiem",Response::HTTP_BAD_REQUEST);
//        }

        DB::beginTransaction();
        try{
            // generate patient id
            if ($request->appointment_for_other_patient==0){
                $request['patient_name']=auth()->user()->name;
                $request['patient_mobile']=auth()->user()->phone;
                $request['patient_age']=auth()->user()->age;
                $request['patient_address']=auth()->user()->address;

                $patientId=$this->storeNewPatient($request,auth()->user()->id)->id;
            }else{ // for new patient ------------
                $patientId=$this->storeNewPatient($request)->id;
            }


            $doctorAppointment=DoctorAppointment::create(
                [
                 'appointment_no'=>$appointmentNo,
                 'user_id'=>\Auth::user()->id,
                 'refer_by_id'=>$request->refer_by_id??null,
                 'patient_id' => $patientId,
                 'appointment_date'=>date('Y-m-d',strtotime($request->appointment_date)),
                 'discount'=>$request->discount??0,
                 'service_charge'=>$request->service_charge??0,
                 'amount'=>$this->calculateDoctorAppointmentAmount($request)['amount']??0,
                 'total_amount'=>$this->calculateDoctorAppointmentAmount($request)['total_amount']??0,
                 'reconciliation_amount'=>$this->calculateDoctorAppointmentAmount($request)['total_amount']??0,
                 'note' => $request->note??'',
                 'source' => DoctorAppointment::SOURCEMOBILE,
                 'created_by' => \Auth::user()->id,
                ]);

           $saveStatus= $this->saveDoctorAppointmentDetails($request,$doctorAppointment->id); //result true Or false
           if ($saveStatus==false){
               DB::rollback();
               Log::info('Hospital wise doctor schedule not found, schedule_id:'.$request->schedule_id);
               return $this->respondWithError('Hospital wise doctor schedule not found, schedule_id:'.$request->schedule_id,[],Response::HTTP_NOT_FOUND);
           }

            DB::commit();
            Log::info('Doctor Appointment Place from api');
            return $this->respondWithSuccess('Doctor Appointment has been Placed successful',['doctor_appointment_id'=>$doctorAppointment->id,'appointment_no'=>$doctorAppointment->appointment_no],Response::HTTP_OK);

        }catch(Exception $e){
            DB::rollback();
            Log::info('Doctor Appointment error api: '.$e->getMessage());
            return $this->respondWithError('Something went wrong, Try again later '.$e->getMessage(),'',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function validationRules($request){
        $rules=[
            'appointment_for_other_patient' => 'required|numeric|in:0,1',
            'appointment_no' => 'unique:doctor_appointments,appointment_no,NULL,id,deleted_at,NULL',
            'patient_name'  => 'required_if:order_for_other_patient,==,1|max:100',
            'patient_age'  => 'required_if:order_for_other_patient,==,1|max:50',
            'patient_address'  => 'required_if:order_for_other_patient,==,1|max:150',
            'patient_mobile'  => "nullable|max:15",
            'patient_email'  => "nullable|max:15",

            'appointment_date'  => "required|date",
            'discount'  => "nullable|numeric|digits_between:1,99999|max:9999",
            'service_charge'  => "numeric|digits_between:1,6",
            'schedule_id' => "exists:hospital_wise_doctor_schedules,id",
            //"hospital_id"   => "required|array|min:1",
        ];
        return $rules;
    }

    public function storeNewPatient($request,$userId=null){
        $patient=new Patient();
        if ($userId!=null){
            $patient=$patient->where('user_id',$userId);
        }else{
            $patient=$patient->where(function ($query)use($request){
                $query->where('mobile',$request->patient_mobile)
                    ->where('name','like', '%'.$request->patient_name.'%');
            });
        }

        $patient=$patient->first();

        if ($patient){
            return $patient;
        }else{
           return $patient= Patient::create([
                'user_id'=>$userId,
                'patient_no'=>Patient::generatePatientId(),
                'name'=>$request->patient_name,
                'age'=>$request->patient_age??18,
                'mobile'=>$request->patient_mobile,
                'address'=>$request->patient_address,
                'refer_by_id'=>auth()->user()->id,
            ]);
        }


    }


    public function calculateDoctorAppointmentAmount($request){

        $amount=0;
        $totalAmount=0;

        $hospitalWiseDoctorSchedule=HospitalWiseDoctorSchedule::where(['id'=>$request->schedule_id,'status'=>HospitalWiseDoctorSchedule::ACTIVE])->first();

            if($hospitalWiseDoctorSchedule) {
                // actual test price after discount -----
                $doctorFee=$hospitalWiseDoctorSchedule->doctor_fee-$hospitalWiseDoctorSchedule->discount;
                $amount+=$doctorFee;
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

    public function saveDoctorAppointmentDetails($request,$appointmentId ){

        $doctorAppointmentDetails='';

            $hospitalWiseDoctorSchedule=HospitalWiseDoctorSchedule::where(['id'=>$request->schedule_id,'status'=>HospitalWiseDoctorSchedule::ACTIVE])->first();
            if($hospitalWiseDoctorSchedule) {
                $doctorAppointmentDetails=DoctorAppointmentDetail::create( [
                    'doctor_appointment_id' => $appointmentId,
                    'doctor_id' => $hospitalWiseDoctorSchedule->doctor_id,
                    'hospital_id' => $hospitalWiseDoctorSchedule->hospital_id,
                    'time_slot' => "$hospitalWiseDoctorSchedule->available_from,$hospitalWiseDoctorSchedule->available_to",
                    'appointment_day' => date('l',strtotime($request->appointment_date)),
                    'doctor_fee' => $hospitalWiseDoctorSchedule->doctor_fee,
                    'discount' => $hospitalWiseDoctorSchedule->discount,
                    'chamber_no' => $hospitalWiseDoctorSchedule->chamber_no,
                    'doctor_schedule_details' => json_encode($hospitalWiseDoctorSchedule),
                    'created_by' => \Auth::user()->id,
                ]);
            }


        if (!empty($doctorAppointmentDetails)){
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
