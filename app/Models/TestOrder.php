<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrder extends Model
{
    use HasFactory,SoftDeletes;

    const PROCESSION=1;
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
}
