<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCollectionLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_collection_id', 'title', 'lang'
    ];
}
