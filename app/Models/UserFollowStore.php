<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'store_id'
    ];

    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'store_id')
            ->select(['id', 'name', 'slug', 'created_at']);
    }
}
