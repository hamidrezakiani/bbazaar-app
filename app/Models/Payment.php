<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{


    protected $casts = [
        'paypal' => 'integer',
        'stripe' => 'integer',
        'flutterwave' => 'integer',
        'razorpay' => 'integer',
        'iyzico_payment' => 'integer',
        'cash_on_delivery' => 'integer',
    ];

    protected $fillable = [
        'cash_on_delivery', 'razorpay_key', 'razorpay_secret', 'stripe_key', 'stripe_secret',
        'paypal', 'paypal_key', 'paypal_secret','admin_id',
        'razorpay', 'stripe',
        'flutterwave', 'fw_environment','fw_public_key', 'fw_secret_key', 'fw_encryption_key',
        'iyzico_payment', 'ip_base_url','ip_api_key', 'ip_secret_key',

    ];

    protected $hidden = [
        'admin_id'
    ];

    use HasFactory;
}
