<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id', 'title', 'description', 'meta_title', 'meta_description', 'lang'
    ];

}
