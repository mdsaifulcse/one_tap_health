<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAppointmentDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='doctor_appointment_details';
    protected $fillable=['doctor_appointment_id','hospital_id','doctor_id','doctor_fee','discount','time_slot','appointment_day','chamber_no','doctor_schedule_details','created_by','updated_by'];

}
