<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleLang extends Model
{
    use HasFactory;


    protected $fillable = [
        'flash_sale_id', 'title', 'lang'
    ];
}
