<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'name', 'slug', 'admin_id', 'meta_title', 'meta_description'
    ];

    protected $hidden = [
        'admin_id'
    ];

}
