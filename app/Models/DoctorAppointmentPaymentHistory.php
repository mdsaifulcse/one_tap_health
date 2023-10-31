<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointmentPaymentHistory extends Model
{
    use HasFactory;

    const INITIATE=0;
    const PENDING=1;
    const COMPLETE=2;
    const FAILED=3;
    const CANCELED=4;

    const CASHONDELIVERY='Cash On Delivery';
    const OFFLINEPAYMENT='Offline Payment';
    const ONLINEPAYMENT='Online Payment';

    protected $table='doctor_appointment_payment_histories';
    protected $fillable=['user_id','doctor_appointment_id','payment_date','payment_amount','store_amount','payment_type','transaction_id','payment_track','payment_gateway','currency','payment_status','created_by'];

    public static function generateDoctorAppointmentTrxID($testOrderId){
        $testOrder=DoctorAppointment::select('appointment_no','id')->where(['id'=>$testOrderId])->first();
        return $testOrder->appointment_no.date('ymdhis');
    }

    public function scopeTotalPaymentAmount($query, $doctorAppointmentId){
        return $query->where(['doctor_appointment_id'=>$doctorAppointmentId,'payment_status'=>self::COMPLETE])->sum('payment_amount');
    }

}
