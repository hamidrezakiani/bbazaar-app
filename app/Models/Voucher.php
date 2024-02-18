<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'status', 'usage_limit', 'limit_per_customer', 'price', 'capped_price',
        'min_spend', 'code', 'start_time', 'end_time', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];
}
