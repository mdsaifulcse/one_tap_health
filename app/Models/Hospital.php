<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;

    protected $table='hospitals';
    protected $fillable=['name','type','branch','address1','address2','photo','contact','latitude','longitude','service_details',
        'status','show_home','sequence','created_by','updated_by'];

    public function hospitalTestPrice(){
        return $this->belongsToMany(Test::class,'hospital_wise_test_prices')
            ->whereNull('hospital_wise_test_prices.deleted_at');
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
