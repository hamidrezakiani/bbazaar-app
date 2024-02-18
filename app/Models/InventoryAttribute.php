<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id', 'attribute_value_id'
    ];

    public function attribute_value()
    {
        return $this->hasOne(AttributeValue::class, 'id', 'attribute_value_id')
            ->select(['id', 'title', 'attribute_id']);
    }


}
