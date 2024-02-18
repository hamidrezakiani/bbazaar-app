<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;


    protected $casts = [
        'predefined' => 'integer',
        'default' => 'integer'
    ];






    protected $fillable = [
        'name', 'code', 'direction', 'status', 'default', 'predefined','admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
