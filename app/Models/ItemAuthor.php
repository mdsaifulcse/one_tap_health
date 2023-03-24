<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAuthor extends Model
{
    use HasFactory,SoftDeletes;

    const ACTIVE=1;
    const INACTIVE=0;

    const YES=1;
    const NO=0;
    protected $table='item_authors';
    protected $fillable=['item_id','author_id'];
}
