<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoneArea extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;

    protected $table='zone_areas';
    protected $fillable=['district_id','name','bn_name','details','status'];

    public function district(){
        return $this->belongsTo(District::class,'district_id','id');
    }

}
