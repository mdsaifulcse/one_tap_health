<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;

    protected $table='doctors';
    protected $fillable=['name','email','mobile','contact','address','current_chamber','photo','bio','institute','designation','degree','department',
        'specialist','bmdc_no','status','sequence'];

    public static function department(){
       return [
           'anesthetics'=>'Anesthetics',
           'breast screening'=>'Breast Screening',
           'cardiology'=>'Cardiology',
           'ear nose and throat'=>'Ear Nose and Throat (ENT)',
           'elderly services department'=>'Elderly Services Department',
           'gastroenterology'=>'Gastroenterology',
           'gynecology'=>'Gynecology',
           'hematology'=>'Hematology',
           'neonatal unit'=>'Neonatal Unit',
           'neurology'=>'Neurology',
           'nutrition and dietetics'=>'Nutrition and Dietetics',
           'obstetrics and gynecology units'=>'Obstetrics and Gynecology Units',
           'oncology'=>'Oncology',
           'orthopedics'=>'Orthopedics',
           'physiotherapy'=>'Physiotherapy',
           'sexual health'=>'Sexual health',
           'urology'=>'Urology',
       ];
    }
    public static function degree(){
      return [
           'doctor of medicine'=>'Doctor of Medicine(DM)',
           'doctor of osteopathic medicine'=>'Doctor of Osteopathic Medicine(DO)',
           'bachelor of medicine and bachelor of science'=>'Bachelor of Medicine and Bachelor of Science(MBBS)',
           'doctor of philosophy'=>'Doctor of Philosophy(PhD)',
           'doctor of nursing practice'=>'Doctor of Nursing Practice(DNP)',
           'certified nurse practitioner'=>'Certified Nurse Practitioner (CNP)',
           'certified neonatal nurse practitioner (CNNP)'=>'Certified Neonatal Nurse Practitioner (CNNP)',
           'physician assistant'=>'Physician Assistant (PA)',
           'clinical nurse specialist'=>'Clinical Nurse Specialist (CNS)',
           'certified nurse midwife'=>'Certified Nurse Midwife (CNM)',
       ];
    }

    public function doctorSchedules(){
        return $this->hasMany(HospitalWiseDoctorSchedule::class,'doctor_id','id')->where(['status'=>HospitalWiseDoctorSchedule::ACTIVE]);
    }

    public static function countActiveDoctor(){
       return self::where(['status'=>self::ACTIVE])->count();
    }
    public static function countInactiveDoctor(){
       return self::where(['status'=>self::INACTIVE])->count();
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
