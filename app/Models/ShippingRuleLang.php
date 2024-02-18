<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRuleLang extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_rule_id', 'title', 'lang'
    ];
}
