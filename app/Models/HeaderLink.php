<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderLink extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'url', 'type', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];


}


