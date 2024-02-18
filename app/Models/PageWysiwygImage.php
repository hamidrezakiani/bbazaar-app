<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageWysiwygImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id', 'image', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
