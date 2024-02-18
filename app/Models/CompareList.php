<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class CompareList extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'product_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->leftJoin('flash_sales', function ($join) {

                $join->on('products.id', '=', 'flash_sale_products.product_id');

                $join->leftJoin('flash_sale_products', function($join) {
                    $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                });
                $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
            })
            ->select('products.id', 'products.title', 'products.slug',
                'products.selling', 'products.offered',
                'products.image', 'products.review_count', 'products.rating', 'products.shipping_rule_id',
                'flash_sale_products.price',
                'flash_sales.end_time');
    }
}
