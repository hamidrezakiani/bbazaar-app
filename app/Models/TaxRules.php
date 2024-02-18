<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'admin_id', 'price'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
