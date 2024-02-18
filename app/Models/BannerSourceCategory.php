<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerSourceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'banner_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')
            ->select(['id', 'title']);
    }
}
