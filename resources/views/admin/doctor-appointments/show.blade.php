
<div class="modal-header">
    <h4 class="modal-title">Doctor Appointment Details</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="row justify-content-center">
        <div class="col-md-12 ">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Appointment No.: #{{$doctorAppointment->appointment_no}} <br>
                            Appointment Date.: {{date('d-M-Y',strtotime($doctorAppointment->appointment_date))}} <br>
                            Amount: Tk.{{$doctorAppointment->reconciliation_amount}} <br>
                            Patient Name: {{$doctorAppointment->patient->name}} <br>
                            Patient Mobile: {{$doctorAppointment->patient->mobile}} <br>
                            Patient Address: {{$doctorAppointment->patient->address}} <br>
                        </div>
                        <div class="col-6">
                            <div class="text-right">
                                <b class="text-success"> <i class="icofont icofont-check-circled text-success"></i> Service Charge: {{$doctorAppointment->service_charge}}</b>
                                <br>
                                Payment Status:
                                @if($doctorAppointment->payment_status==\App\Models\DoctorAppointment::PARTIALPAYMENT)
                                    <b class="badge badge-warning ">Partial Payment</b>

                                @elseif($doctorAppointment->payment_status==\App\Models\DoctorAppointment::FULLPAYMENT)
                                    <b class="badge badge-primary">Full Paid</b>
                                @else
                                    <b class="badge badge-danger ">Due</b>
                                @endif
                                <br>
                                Appointment Status:
                                @if($doctorAppointment->appointment_status==\App\Models\DoctorAppointment::APPOINTMENTCOMPLETED)
                                    <b class="badge badge-success ">Complete</b>

                                @elseif($doctorAppointment->appointment_status==\App\Models\DoctorAppointment::APPOINTMENTPROCESSED)
                                    <b class="badge badge-primary">Processed</b>
                                @else
                                    <b class="badge badge-info ">New</b>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                            <thead>
                            <tr class="">
                                <th width="4">SL.</th>
                                <th>Doctor</th>
                                <th>Hospital</th>
                                <th>Day</th>
                                <th>Time Slot</th>
                                <th>Fee</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @forelse($doctorAppointment->doctorAppointmentDetails as $doctorAppointmentDetail)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$doctorAppointmentDetail->doctor?$doctorAppointmentDetail->doctor->name:''}}</td>
                                    <td>{{$doctorAppointmentDetail->hospital?$doctorAppointmentDetail->hospital->name:''}}</td>
                                    <td>{{$doctorAppointmentDetail->appointment_day}}</td>
                                    <td>{{$doctorAppointmentDetail->appointment_time_slot}}</td>
                                    <td>{{$doctorAppointmentDetail->fee_after_discount}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center"> No Data Found! </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                    <br>
                    <div class="row justify-content-end">
                        <div class="col-5">
                             <div class="table-responsive">
                                 <table class="table table-striped table-hover table-bordered center_table">
                                     <thead>
                                     <tr class="">
                                         <th>Amount</th>
                                         <th>{{$doctorAppointment->amount}}</th>
                                     </tr>
                                     <tr class="">
                                         <th>Discount (-)</th>
                                         <th>{{$doctorAppointment->discount}}</th>
                                     </tr>
                                     <tr class="">
                                         <th class="text-success">Service Charge (+)</th>
                                         <th>{{$doctorAppointment->service_charge}}</th>
                                     </tr>
                                     <tr class="">
                                         <th>Total Amount</th>
                                         <th>{{$doctorAppointment->reconciliation_amount}}</th>
                                     </tr>
                                     </thead>
                                 </table>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
