<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSourceBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'banner_id'
    ];

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id')
            ->select(['id', 'title']);
    }

}
