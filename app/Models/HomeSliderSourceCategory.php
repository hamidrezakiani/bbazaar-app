<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSliderSourceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'home_slider_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')
            ->select(['id', 'title']);
    }
}
