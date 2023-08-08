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
    // Source
    const SOURCEMOBILE='Mobile';
    const SOURCEWEBSITE='Website';
    const SOURCEADMIN='Admin';

    const YES=1;
    const NO=0;
    protected $table='test_orders';
    protected $fillable=['order_no','user_id','refer_by_id','hospital_id','amount','discount','service_charge','total_amount','reconciliation_amount','system_commission','patient_name',
        'patient_id','test_date','approval_status','visit_status','payment_status','delivery_status','delivery_date','source','note','created_by','updated_by'];

    public function patient(){
        return $this->belongsTo(Patient::class,'patient_id','id');
    }
    public function hospital(){
        return $this->belongsTo(Hospital::class,'hospital_id','id');
    }

    public function testOrderDetails(){
        return $this->hasMany(TestOrderDetail::class,'test_order_id','id');
    }

    public static function generateOrderInvoiceNo(){
        $testOrderPrefix='ton-';

        $lastOrderNo=TestOrder::max('order_no');
        if (empty($lastOrderNo)){
            $lastOrderNo=1;
        }else{
            $lastOrderNo=str_replace($testOrderPrefix,'',$lastOrderNo);
            $lastOrderNo+=1;
        }

        $invoiceLength= env('INVOICE_LENGTH',TestOrder::INVOICENOLENGTH);
        return $testOrderPrefix.str_pad($lastOrderNo,$invoiceLength,"0",false);
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
