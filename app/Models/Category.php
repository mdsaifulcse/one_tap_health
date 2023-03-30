<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;
    const OTHER=2;
    const DRAFT=3;

    const YES=1;
    const NO=0;

    protected $table='categories';
    protected $fillable=['category_name','category_name_bn','link','status','show_home','sequence','short_description','icon_photo',
        'icon_class','created_by','updated_by'];

    public function subCategoryData(){
        return $this->hasMany(SubCategory::class,'category_id','id');
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
