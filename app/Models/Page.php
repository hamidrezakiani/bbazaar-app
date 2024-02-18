<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'meta_title', 'meta_description', 'page_from_component', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
