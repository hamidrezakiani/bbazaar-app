<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'country', 'state', 'price', 'pickup_price', 'pickup_point', 'shipping_rule_id', 'admin_id' , 'day_needed'
    ];

    protected $hidden = [
        'admin_id',  'created_at',  'updated_at'
    ];

}
