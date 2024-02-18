<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id', 'title', 'meta_title', 'meta_description', 'lang'
    ];
}
