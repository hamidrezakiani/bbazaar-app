<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSourceProduct extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id', 'banner_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->select(['id', 'title', 'image', 'selling', 'offered']);
    }
}
