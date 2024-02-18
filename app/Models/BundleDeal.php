<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BundleDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'free', 'admin_id', 'buy'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
