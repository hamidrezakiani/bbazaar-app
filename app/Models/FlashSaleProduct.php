<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'flash_sale_id', 'price', 'admin_id'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function public_flash_sale()
    {
        return $this->hasOne(FlashSale::class, 'id', 'flash_sale_id');
    }


    public function flash_sale()
    {
        return $this->hasOne(FlashSale::class, 'id', 'flash_sale_id');
    }


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->select(['id', 'title', 'image', 'selling', 'offered']);
    }
}
