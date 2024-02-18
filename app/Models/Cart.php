<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use OwenIt\Auditing\Contracts\Auditable;

class Cart extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    

    protected $fillable = [
        'product_id', 'inventory_id', 'user_id', 'quantity', 'selected',
        'shipping_place_id', 'shipping_type', 'user_token'
    ];

    public function shipping_place()
    {
        return $this->hasOne(ShippingPlace::class, 'id', 'shipping_place_id');
    }

    public function product_inner()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->with('bundle_deal')
            ->with('tax_rules')
            ->leftJoin('flash_sales', function ($join) {

                $join->on('products.id', '=', 'flash_sale_products.product_id');

                $join->leftJoin('flash_sale_products', function($join) {
                    $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                });
                $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
            })
            ->select('products.id',  'products.bundle_deal_id',
                'products.title', 'products.selling', 'products.offered',
                'products.image', 'products.review_count', 'products.rating',
                'products.shipping_rule_id',
                'products.tax_rule_id',
                'products.admin_id',
                'products.purchased',
                'flash_sale_products.price',
                'flash_sales.end_time')
            ->where('products.status', Config::get('constants.status.PUBLIC'));
    }


    public function flash_product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->with('bundle_deal')
            ->with('tax_rules')
            ->leftJoin('flash_sales', function ($join) {

                $join->on('products.id', '=', 'flash_sale_products.product_id');

                $join->leftJoin('flash_sale_products', function($join) {
                    $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                });
                $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
            })

            ->select('products.id', 'products.bundle_deal_id', 'products.title', 'products.slug',
                'products.selling', 'products.offered', 'products.tax_rule_id',
                'products.image', 'products.review_count', 'products.rating', 'products.shipping_rule_id',
                'flash_sale_products.price',
                'flash_sales.end_time');
    }


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->select(['id', 'title', 'image', 'selling', 'offered', 'shipping_rule_id', 'status']);
    }

    public function updated_inventory()
    {
        return $this->hasOne(UpdatedInventory::class, 'id', 'inventory_id');
    }


    /*public function inventory()
    {
        return $this->hasOne(Inventory::class, 'id', 'inventory_id');
    }*/
}
