<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrderPaymentHistory extends Model
{
    use HasFactory,SoftDeletes;
    const INITIATE=0;
    const PENDING=1;
    const COMPLETE=2;
    const FAILED=3;
    const CANCELED=4;

    const CASHONDELIVERY='Cash On Delivery';
    const OFFLINEPAYMENT='Offline Payment';
    const ONLINEPAYMENT='Online Payment';

    protected $table='test_order_payment_histories';
    protected $fillable=['user_id','test_order_id','payment_date','payment_amount','store_amount','payment_type','transaction_id','payment_track','payment_gateway','currency','payment_status','created_by'];

    public static function generateTestOrderTrxID($testOrderId){
        $testOrder=TestOrder::select('order_no','id')->where(['id'=>$testOrderId])->first();
       return $testOrder->order_no.date('ymdhis');
    }

    public function scopeTotalPaymentAmount($query, $testOrderId){
       return $query->where(['test_order_id'=>$testOrderId,'payment_status'=>self::COMPLETE])->sum('payment_amount');
    }

}
