<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrder extends Model
{
    use HasFactory,SoftDeletes;

    const INVOICENOLENGTH=8;
    const PROCESSION=0;
    const PARTIALDELIVERED=2;
    const DELIVERED=3;

    const PENDING=0;
    const APPROVE=1;
    const CANCEL=2;

    // payment status -------
    const PARTIALPAYMENT=1;
    const FULLPAYMENT=2;

    const YES=1;
    const NO=0;
    protected $table='test_orders';
    protected $fillable=['order_no','user_id','amount','discount','service_charge','total_amount','reconciliation_amount','patient_name',
        'patient_mobile','patient_address','test_date','approval_status','visit_status','payment_status','delivery_status','delivery_date','created_by','updated_by'];

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
