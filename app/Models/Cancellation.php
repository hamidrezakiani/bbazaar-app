<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{

    protected $casts = [
        'refunded' => 'integer'
    ];


    protected $fillable = [
        'order_id', 'user_id', 'title', 'message', 'refunded', 'user_token'
    ];

    use HasFactory;
}
