<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorAppointment extends Model
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
    protected $table='doctor_appointments';
    protected $fillable=['appointment_no','user_id','refer_by_id','hospital_id','amount','discount','service_charge','total_amount','reconciliation_amount','system_commission',
        'patient_id','appointment_date','approval_status','appointment_status','payment_status','source','note','created_by','updated_by'];

}
