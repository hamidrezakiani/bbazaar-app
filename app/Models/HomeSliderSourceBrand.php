<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSliderSourceBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'home_slider_id'
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id')
            ->select(['id', 'title']);
    }

}
