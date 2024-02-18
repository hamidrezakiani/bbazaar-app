<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 'type', 'source_type', 'tags', 'url', 'title', 'admin_id', 'status', 'slug'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function source_brands()
    {
        return $this->hasMany(HomeSliderSourceBrand::class, 'home_slider_id', 'id');
    }

    public function source_categories()
    {
        return $this->hasMany(HomeSliderSourceCategory::class, 'home_slider_id', 'id');
    }

    public function source_sub_categories()
    {
        return $this->hasMany(HomeSliderSourceSubCategory::class, 'home_slider_id', 'id');
    }

    public function source_products()
    {
        return $this->hasMany(HomeSliderSourceProduct::class, 'home_slider_id', 'id');
    }
}
