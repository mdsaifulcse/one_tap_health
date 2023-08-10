<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestOrderDetail extends Model
{
    use HasFactory,SoftDeletes;

    const PROCESSION=0;
    const PARTIALDELIVERED=2;
    const DELIVERED=3;

    const PENDING=0;
    const APPROVE=1;
    const CANCEL=2;

    protected $table='test_order_details';
    protected $fillable=['test_order_id','hospital_id','test_id','price','approval_status','delivery_status','delivery_date','created_by','updated_by'];

    protected $appends=['price_after_discount'];

    public function test(){
        return $this->belongsTo(Test::class,'test_id','id')->withTrashed();
    }

    public function getPriceAfterDiscountAttribute(){
        return $this->price-$this->discount;
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
