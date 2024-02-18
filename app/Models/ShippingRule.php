<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id', 'title', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function shipping_places()
    {
        return $this->hasMany(ShippingPlace::class, 'shipping_rule_id', 'id');
    }
}
