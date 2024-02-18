<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StoreLang extends Model
{
    use HasFactory;


    protected $fillable = [
        'store_id', 'name', 'meta_title', 'meta_description', 'lang'
    ];
}
