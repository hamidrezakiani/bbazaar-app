<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdatedInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'quantity', 'price'
    ];

    public function inventory_attributes()
    {
        return $this->hasMany(InventoryAttribute::class, 'inventory_id', 'id')
            ->select( 'inventory_id', 'attribute_value_id');
    }
}
