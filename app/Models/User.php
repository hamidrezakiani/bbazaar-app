<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasApiTokens;
    use \OwenIt\Auditing\Auditable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $casts = [
        'verified' => 'integer',
        'remember_token' => 'integer'
    ];


    protected $fillable = ['name', 'email', 'password', 'code', 'default_address', 'phone',
        'verified', 'remember_token', 'facebook_id', 'google_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function wishLists()
    {
        return $this->hasMany(UserWishlist::class,'user_id','id');
    }
}
