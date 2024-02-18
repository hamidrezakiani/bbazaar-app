<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSourceSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id', 'banner_id'
    ];

    public function sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id')
            ->select(['id', 'title']);
    }
}
