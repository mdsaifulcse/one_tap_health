<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalWiseDoctorSchedule extends Model
{
    use HasFactory,SoftDeletes;
    protected $appends = ['doctorAvailableDay'];
    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;

    protected $table='hospital_wise_doctor_schedules';
    protected $fillable=['doctor_id','hospital_id','doctor_fee','discount','available_from','available_to','available_day','status','created_by','updated_by'];

    public function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id','id');
    }
    public function hospital(){
        return $this->belongsTo(Hospital::class,'hospital_id','id');
    }

    public function getDoctorAvailableDayAttribute()
    {
        return ucwords(implode(', ',json_decode($this->available_day,true)));
    }

    public static function availableDays(){
        return [
            'saturday'=>'Saturday',
            'sunday'=>'Sunday',
            'monday'=>'Monday',
            'tuesday'=>'Tuesday',
            'wednesday'=>'Wednesday',
            'thursday'=>'Thursday',
            'friday'=>'Friday',
        ];
    }

    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'
    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(\Auth::check()){
                $query->created_by = \Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(\Auth::check()){
                $query->updated_by = \Auth::user()->id;
            }
        });
    }

}
