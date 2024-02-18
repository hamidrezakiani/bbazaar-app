<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSliderSourceSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_slider_id', 'sub_category_id'
    ];

    public function sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id')
            ->select(['id', 'title']);
    }
}
