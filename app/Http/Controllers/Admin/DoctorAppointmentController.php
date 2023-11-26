<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAppointment;
use App\Models\DoctorAppointmentDetail;
use App\Models\Hospital;
use App\Models\HospitalWiseDoctorSchedule;
use App\Models\HospitalWiseTestPrice;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\TestOrder;
use App\Models\TestOrderDetail;
use App\Models\TestOrderPaymentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator,MyHelper,DB,Yajra\DataTables\DataTables;

class DoctorAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $allData=DoctorAppointment::with('doctorAppointmentDetails');

            return  DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('hospitals_name',function (DoctorAppointment $appointment){
                    return $appointment->doctorAppointmentDetails[0]->hospital->name??'N/A';
                })
                ->addColumn('doctor_name',function (DoctorAppointment $appointment){
                    return $appointment->doctorAppointmentDetails[0]->doctor->name??'N/A';
                })
                ->addColumn('patient_name',function (DoctorAppointment $appointment){
                    return $appointment->patient->name??'N/A';
                })
                ->addColumn('patient_mobile',function (DoctorAppointment $appointment){
                    return $appointment->patient->mobile??'N/A';
                })
                ->addColumn('appointment_date','
                    {{date(\'M-d-Y\',strtotime($appointment_date))}}
                ')
                ->addColumn('appointment_status','
                <a href="#"
                @if($appointment_status!=\App\Models\DoctorAppointment::APPOINTMENTCOMPLETED)
                 data-toggle="modal" data-target="#myModal{{$id}}" 
                 @endif
                 title="Click for changing status"> 
                     @if($appointment_status==\App\Models\DoctorAppointment::APPOINTMENTPROCESSED)
                        <button class="btn btn-info btn-sm">Processed</button>
                        
                        @elseif($appointment_status==\App\Models\DoctorAppointment::APPOINTMENTCOMPLETED)
                        <button class="btn btn-success btn-sm">Completed</button>
                            @else
                            <button class="btn btn-primary btn-sm">New</button>
                        @endif
                 </a>
                 
                     <!-- Modal -->
                      <div class="modal fade" id="myModal{{$id}}" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          {!! Form::open(array(\'route\' => [\'admin.doctor-appointments.update\', $id],\'method\'=>\'PUT\',\'class\'=>\'kt-form kt-form--label-right\',\'files\'=>true)) !!}
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class ="modal-title text-danger">Are sure to change Appointment status?</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                               <div class="form-group row">
                                    
                                    <div class="col-md-10">
                                        {{Form::select(\'appointment_status\', 
                                        [
                                        \App\Models\DoctorAppointment::APPOINTMENTNEW  => \'New\' ,
                                         \App\Models\DoctorAppointment::APPOINTMENTPROCESSED  => \'Processed\',
                                        \App\Models\DoctorAppointment::APPOINTMENTCOMPLETED  => \'Completed\'
                                        ],[$appointment_status], [\'class\' => \'form-control\'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="display:block;">
                              <button type="submit" class="btn btn-warning pull-left" onclick="return confirm(\'are you sure?\')">Save    </button>
                            </div>
                          </div>
                           {!! Form::close() !!}
                          
                        </div>
                      </div>
                ')
                ->addColumn('payment_status','
                <a href="#" data-toggle="tooltip" title="Click Here For Payment"> 
                     @if($payment_status==\App\Models\DoctorAppointment::PARTIALPAYMENT)
                        <button class="btn btn-warning btn-sm">Partial</button>
                        
                        @elseif($payment_status==\App\Models\DoctorAppointment::FULLPAYMENT)
                        <button class="btn btn-success btn-sm">Full</button>
                            @else
                            <button class="btn btn-danger btn-sm">Due</button>
                        @endif
                 </a>
                ')
                ->addColumn('created_at','
                    {{date(\'M-d-Y\',strtotime($created_at))}}
                ')
                ->addColumn('control','
                    <span class=\'dropdown\'>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0)" onclick="showDoctorAppointmentDetailsModal({{$id}})" class="btn btn-success btn-sm" title="Click here for order details">Appointment Details <i class="icofont icofont-eye"></i> </a></li>
                           
                            @if($payment_status==\App\Models\DoctorAppointment::PENDING)
                            <li>
                                {!! Form::open(array(\'route\' => [\'admin.doctor-appointments.destroy\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}
                                <button type="button" class="btn btn-danger btn-sm" onclick=\'return deleteConfirm("deleteForm{{$id}}")\'>Delete <i class="icofont icofont-trash"></i></button>
                                {!! Form::close() !!}
                            </li>
                            @endif
                            
                        </ul>
                    </span>
                ')
                ->rawColumns(['hospitals_name','patient_name','patient_mobile','appointment_date','appointment_status','payment_status','created_at','control'])
                ->toJson();
        }

        return view('admin.doctor-appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.doctor-appointments.create');
    }

    public function loadDoctorWiseDoctorSchedules($doctorId){
        $setting=Setting::first();
        $doctor=Doctor::with('doctorSchedules','doctorSchedules.hospital')->findOrFail($doctorId);

        return view('admin.doctor-appointments.load-doctor-wise-doctor-schedules',compact('doctor','setting'));
    }


    public function store(Request $request)
    {
        $appointmentNo=DoctorAppointment::generateAppointmentInvoiceNo();
        $request['appointment_no']=$appointmentNo;
        $rules=$this->validationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        $appointmentDay=strtolower(date('l',strtotime($request->appointment_date)));

        $hospitalWiseDoctorSchedule=HospitalWiseDoctorSchedule::where(['status'=>HospitalWiseDoctorSchedule::ACTIVE])->findOrFail($request->schedule_id);
        $availableDay=json_decode($hospitalWiseDoctorSchedule->available_day);

        if (!in_array($appointmentDay,$availableDay)) {
            return redirect()->back()->with('error',"Appointment date must be according to $hospitalWiseDoctorSchedule->doctorAvailableDay");
        }


        DB::beginTransaction();
        try{

            if ($request->patient_state=='existing_patient'){
                $patientId=$request->patient_id;
            }else{ // for new patient ------------
                $patientId=$this->storeNewPatient($request)->id;
            }


            $siteSetting=Setting::first();
            $request['service_charge']=$siteSetting->appointment_service_charge??0;

            $doctorAppointment=DoctorAppointment::create(
                [
                    'appointment_no'=>$appointmentNo,
                    'user_id'=>\Auth::user()->id,
                    'refer_by_id'=>$request->refer_by_id??null,
                    'patient_id' => $patientId,
                    'appointment_date'=> date('Y-m-d',strtotime($request->appointment_date)),
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
                return redirect()->back()->with('error','Hospital wise doctor schedule not found, schedule_id:'.$request->schedule_id);
            }

            DB::commit();
            Log::info('Doctor Appointment Place from admin');
            return redirect()->back()->with('success','Doctor Appointment has been Placed successful');

        }catch(Exception $e){
            DB::rollback();
            Log::info('Doctor Appointment error admin: '.$e->getMessage());
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    public function validationRules($request){
        $rules=[
            'patient_no' => 'unique:patients,patient_no,NULL,id,deleted_at,NULL',
            'patient_id'  => "required_if:patient_state,==,existing_patient",
            'patient_name'  => 'required_if:patient_state,==,new_patient|max:100',
            'patient_age'  => 'required_if:patient_state,==,new_patient|max:50',
            'patient_address'  => 'required_if:patient_state,==,new_patient|max:150',
            'patient_mobile'  => "nullable|max:15",
            'patient_email'  => "nullable|max:15",

            'appointment_no' => 'unique:doctor_appointments,appointment_no,NULL,id,deleted_at,NULL',
            'appointment_date'  => "required|date",
            'discount'  => "nullable|numeric|digits_between:1,99999|max:9999",
            'service_charge'  => "numeric|digits_between:1,6",
            'schedule_id' => "exists:hospital_wise_doctor_schedules,id",
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
                'refer_by_id'=>$request->refer_by_id??null,
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
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorAppointment $doctorAppointment)
    {
         $doctorAppointment->load(['doctorAppointmentDetails',
            'doctorAppointmentDetails.hospital:id,name,branch,address1','doctorAppointmentDetails.doctor:id,name','patient:id,name,mobile,address']);
        return view('admin.doctor-appointments.show',compact('doctorAppointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorAppointment $doctorAppointment)
    {
        $data=$hospital;
        $maxSerial=Hospital::max('sequence');
        return view('admin.doctor-appointments.edit',compact('data','maxSerial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorAppointment $doctorAppointment)
    {
        try{

            //return $request;
            $doctorAppointment->load('patient');

            $smsInfo='SMS NOT Sent';

            $doctorAppointment->update(['appointment_status'=>$request->appointment_status]);

            // Sending Appointment confirmation -------------
            if ($request->appointment_status==DoctorAppointment::APPOINTMENTPROCESSED & !empty($doctorAppointment->patient->mobile)){
                $receiver=$doctorAppointment->patient->mobile;
                $smsBody="Confirmation message.\r\n".
                    "Your appointment: $doctorAppointment->appointment_no has been confirmed by OneTapHealth admin.\r\n".
                    "For any assistance please call: ".env('ANY_ASSISTANCE_CALL');

                 $response= \MyHelper::sendConfirmationSMS($receiver,$smsBody);


                if (strpos($response, "200") !== false){
                    $smsInfo='SMS Sent';
                }

                Log::info('Appointment SMS successful : receiver: '.$receiver." message : $smsBody");
            }


            return redirect()->back()->with('success',"Appointment Status has been Successfully Updated & ".$smsInfo);
        }catch(Exception $e){
            Log::error('Appointment confirmation error:'.$e->getMessage());
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorAppointment  $doctorAppointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $myDoctorAppointments=DoctorAppointment::with('doctorAppointmentDetails')->findOrFail($id);
            $myDoctorAppointments->doctorAppointmentDetails->each(function ($detail){
                $detail->delete();
            });
            $myDoctorAppointments->delete();
            Log::info('From Admin, Delete Doctor Appointment ID:'.$id);
            return redirect()->back()->with('success',"Appointment Status has been Successfully Deleted");
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }

}
