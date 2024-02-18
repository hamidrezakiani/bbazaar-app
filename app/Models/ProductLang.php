<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'description', 'title', 'overview', 'unit', 'badge', 'meta_title',
        'meta_description', 'lang'
    ];
}
