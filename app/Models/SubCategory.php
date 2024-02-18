<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'status', 'featured', 'admin_id', 'category_id', 'slug', 'meta_title', 'meta_description'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')
            ->select(['id', 'title', 'slug']);
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id', 'id');
    }
}
