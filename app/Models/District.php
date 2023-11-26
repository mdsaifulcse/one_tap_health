<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;

    protected $table='districts';
    protected $fillable=['name','bn_name','lat','long','status'];

    public function zoneArea(){
        return $this->hasMany(ZoneArea::class,'district_id','id');
    }

}
