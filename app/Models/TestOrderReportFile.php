<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrderReportFile extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;
    const INITIALUPLOAD=2;

    protected $casts = [
        'files' => 'array',
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s'
    ];

    protected $table='test_order_report_files';
    protected $fillable=['test_order_id','files','title','notes','status','created_by','updated_by'];
}
