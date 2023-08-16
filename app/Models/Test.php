<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory,SoftDeletes;
    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;

    protected $table='tests';
    protected $fillable=['title','sub_title','branch','description','icon_photo','icon_class','category_id','subcategory_id','third_category_id',
        'status','show_home','sequence','created_by','updated_by'];

    public function testCategory()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function testSubCategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

    public function testThirdCategory()
    {
        return $this->belongsTo(ThirdSubCategory::class,'third_category_id','id');
    }

    public function testWiseHospitals(){
        return $this->belongsToMany(Hospital::class,'hospital_wise_test_prices')
            ->whereNull('hospital_wise_test_prices.deleted_at')->withPivot('price','discount','vat_percent')->withTrashed();
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
