<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;


class Admin extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
    use \OwenIt\Auditing\Auditable;



    protected $casts = [
        'remember_token' => 'integer'
    ];

    protected $fillable = [
        'name',
        'username',
        'email',
        'commission',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
