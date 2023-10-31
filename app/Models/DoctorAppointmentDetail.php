<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAppointmentDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $appends=['fee_after_discount','appointment_time_slot'];
    protected $table='doctor_appointment_details';
    protected $fillable=['doctor_appointment_id','hospital_id','doctor_id','doctor_fee','discount','time_slot','appointment_day','chamber_no','doctor_schedule_details','created_by','updated_by'];

    public function getFeeAfterDiscountAttribute(){
        return $this->doctor_fee-$this->discount;
    }

    public function hospital(){
        return $this->belongsTo(Hospital::class,'hospital_id','id')->withTrashed();
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id','id')->withTrashed();
    }

    public function getAppointmentTimeSlotAttribute(){

        $timeSlot=explode(',',$this->time_slot);

        $availAbleFrom=date('h:i A', strtotime($timeSlot[0]));
        $availAbleTo=date('h:i A', strtotime($timeSlot[1]));
        return $availAbleFrom.' To '.$availAbleTo;

    }


}
