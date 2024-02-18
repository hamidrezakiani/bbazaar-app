<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'status', 'admin_id', 'slug', 'meta_title', 'meta_description'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function public_sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id')
            ->where('status', Config::get('constants.status.PUBLIC'))
            ->select('id','title', 'slug', 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
