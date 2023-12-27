<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */



    const PENDING=0;
    const APPROVED=1;
    const REJECTED=2;

    const ACTIVE=1;
    const INACTIVE=0;


    const DEVELOPER=1;
    const SUPERADMIN=2;
    const ADMIN=3;
    const USER=4;
    const HOSPITAL=5;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'birth_date',
        'address',
        'firebase_token',
        'status',
        'profile_photo_path',
        'user_role',
        'password',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //'profile_photo_url',
    ];



    public function userRoles() {
        return [
            self::SUPERADMIN=>'Super Admin',
            self::ADMIN=>'Admin',
            //self::LIBRARIAN=>'Librarian',
            self::USER=>'General User',
        ];
    }
    public function getUserStatusAttribute() {

        if ($this->status==User::ACTIVE){
            return 'Active';
        }elseif($this->status==User::INACTIVE){
            return 'Inactive';
        }
    }
    public function getApprovalStatusAttribute() {

        if ($this->status==User::APPROVED){
            return 'Approved';
        }elseif($this->status==User::REJECTED){
            return 'Rejected';
        }elseif($this->status==User::PENDING){
            return 'Pending';
        }
    }

    public function scopeAllUser($q,$userRole=null){
        return $q->whereIn('user_role',$userRole);
    }

    public function scopeActiveUser($q,$userRole){
        return $q->where(['status'=>self::APPROVED])->whereIn('user_role',$userRole);
    }


    public function allGeneralUsers(){
        return $this->where('user_role',self::USER)->get();
    }

    public function getIsAdminAttribute(){
         if ($this->user_role==self::ADMIN){
             return true;
         }elseif ($this->user_role==self::SUPERADMIN){
             return true;
         }
         else{
            return false;
         }
    }

    public function profile(){
        return $this->hasOne(UserProfile::class);
    }
}
