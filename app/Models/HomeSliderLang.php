<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSliderLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_slider_id', 'title', 'lang'
    ];
}
