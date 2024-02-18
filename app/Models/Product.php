<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use OwenIt\Auditing\Contracts\Auditable;


class Product extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'id', 
        'title', 
        'purchased', 
        'selling', 
        'offered', 
        'image', 
        'unit', 
        'video', 
        'video_thumb', 
        'badge',
        'status', 
        'admin_id', 
        'subcategory_id', 
        'category_id', 
        'brand_id', 
        'warranty', 
        'refundable',
        'description', 
        'overview', 
        'tags', 
        'tax_rule_id', 
        'shipping_rule_id', 
        'meta_title', 
        'meta_description',
        'review_count', 
        'rating', 
        'bundle_deal_id', 
        'slug'
    ];

    protected $hidden = [];


    public function flash_sale_product()
    {
        return $this->hasMany(FlashSaleProduct::class, 'product_id', 'id')
            ->with('flash_sale');
    }


    public function sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'subcategory_id')
            ->select(['id', 'title', 'category_id', 'slug']);
    }


    public function tax_rules()
    {
        return $this->hasOne(TaxRules::class, 'id', 'tax_rule_id');
    }


    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->select(['id', 'title', 'slug']);
    }


    public function shipping_rule()
    {
        return $this->hasOne(ShippingRule::class, 'id', 'shipping_rule_id')->select(['id', 'title']);
    }


    public function product_collections()
    {
        return $this->hasMany(CollectionWithProduct::class, 'product_id', 'id')
            ->select(['id', 'product_id', 'product_collection_id']);
    }


    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }


    public function product_image_names()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }


    public function current_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'category_id')
            ->offset(0)
            ->limit(10)
            ->select('id', 'category_id', 'title', 'slug')
            ->where('status', Config::get('constants.status.PUBLIC'));
    }


    public function store()
    {
        return $this->hasOne(Store::class, 'admin_id', 'admin_id');
    }


    public function bundle_deal()
    {
        return $this->hasOne(BundleDeal::class, 'id', 'bundle_deal_id')
            ->select(['id', 'buy', 'free', 'title']);
    }


    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id')
            ->select(['title', 'id']);
    }

    public function scopePublic(Builder $q)
    {
        return $q->where('status', 1);
    }

    public function scopePrivate(Builder $q)
    {
        return $q->where('status', 0);
    }
}
