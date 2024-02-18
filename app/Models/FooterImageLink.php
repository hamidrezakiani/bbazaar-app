<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterImageLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'link', 'image', 'type', 'status', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];

}
