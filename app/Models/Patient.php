<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    const PATIENTIDLENGTH=8;
    const ACTIVE=1;
    const INACTIVE=0;

    protected $table='patients';
    protected $fillable=['user_id','patient_no','name','email','mobile','age','address','details','status','sequence','refer_by_id','created_by','updated_by'];

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public static function generatePatientId(){
        $patientId=Patient::max('patient_no');
        if (empty($patientId)){
            $patientId=1;
        }else{
            $patientId+=1;
        }

        $invoiceLength= env('PATIENT_ID_LENGTH',Patient::PATIENTIDLENGTH);
        return str_pad($patientId,$invoiceLength,"0",false);
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
