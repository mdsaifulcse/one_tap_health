<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HospitalWiseTestPrice extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;

    protected $table='hospital_wise_test_prices';
    protected $fillable=['test_id','hospital_id','price','discount','vat_percent','status','created_by','updated_by'];

    public function hospital(){
        return $this->belongsTo(Hospital::class,'hospital_id','id');
    }
    public function test(){
        return $this->belongsTo(Test::class,'test_id','id');
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
