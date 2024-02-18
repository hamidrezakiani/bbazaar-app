<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandLang extends Model
{
    use HasFactory;


    protected $fillable = [
        'brand_id', 'title', 'lang'
    ];
}
