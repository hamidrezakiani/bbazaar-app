<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GuestUser extends Model implements Auditable
{
    
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'email', 'user_token', 'default_address'
    ];
}
