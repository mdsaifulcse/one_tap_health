<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrderCancelRequest extends Model
{
    use HasFactory,SoftDeletes;

    // Cancel Status -------
    const PENDING=0;
    const APPROVED=1;

    // Refund Status --------
    const NOTREFUNDED=0;
    const REFUNDED=1;

    protected $table='test_order_cancel_requests';

    protected $fillable=['test_order_id','notes','cancel_status','refund_status','refund_amount','cancel_by','cancel_at','refund_by','refund_at'];

    public function testOrder(){
        return $this->belongsTo(TestOrder::class,'test_order_id','id');
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
