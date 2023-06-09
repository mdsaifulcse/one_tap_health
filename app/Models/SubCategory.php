<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes;
    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;
    protected $table='sub_categories';
    protected $fillable=['category_id','sub_category_name','sub_category_name_bn','link','status','sequence','icon_photo','icon_class','short_description','created_by','updated_by'];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function thirdSubCategory(){
        return $this->hasMany(ThirdSubCategory::class,'sub_category_id','id')->orderBy('sequence','ASC')
            ->where(['status'=>ThirdSubCategory::ACTIVE]);
    }

    public function thirdSubAsThirdSubMenu(){
        return $this->hasMany(ThirdSubCategory::class,'sub_category_id','id');
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
