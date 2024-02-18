<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'attributes', 'product_id', 'quantity', 'price', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];

}
