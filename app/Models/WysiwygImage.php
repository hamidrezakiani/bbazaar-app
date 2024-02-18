<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WysiwygImage extends Model
{
    // This is used for product
    use HasFactory;

    protected $fillable = [
        'item_id', 'image', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
