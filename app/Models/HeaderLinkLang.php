<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderLinkLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_link_id', 'title', 'lang'
    ];
}
