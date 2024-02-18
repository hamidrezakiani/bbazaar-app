<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionEmailFormat extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'subject', 'body', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
