<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biggapon extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE='Active';
    const INACTIVE='Inactive';

    const TOP='Top';
    const MIDDLE='Middle';
    const BOTTOM='Bottom';
    const SIDE='Side';

    const HOME_PAGE='Home Page';
    const DETAIL_PAGE='Detail Page';
    const OTHER_PAGE='Other Page';

    protected $table='biggapons';
    protected $fillable=['image','target_url','place','show_on_page','status','active_till','sequence','created_by','updated_by'];

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
