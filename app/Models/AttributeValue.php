<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'admin_id', 'attribute_id'
    ];

    protected $hidden = [
        'admin_id'
    ];

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id')
            ->select(['id', 'title']);
    }

}
