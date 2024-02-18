<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'status', 'featured', 'admin_id', 'slug'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
