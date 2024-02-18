<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ProductCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'status', 'admin_id', 'slug'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function product_collections()
    {
        return $this->hasMany(CollectionWithProduct::class, 'product_collection_id', 'id')
            ->join('products', function ($join) {

                $join->on('products.id', '=', 'collection_with_products.product_id');

                $join->where('products.status', Config::get('constants.status.PUBLIC'));
                $join->leftJoin('flash_sales', function ($join) {

                    $join->on('products.id', '=', 'flash_sale_products.product_id');

                    $join->leftJoin('flash_sale_products', function ($join) {
                        $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                    });
                    $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                        ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                });

            })
            ->select('collection_with_products.*', 'products.id', 'products.title', 'products.badge',
                'products.selling', 'products.offered', 'products.slug',
                'products.image', 'products.review_count', 'products.rating', 'products.shipping_rule_id',
                'flash_sale_products.price',
                'flash_sales.end_time');
    }


}
