<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderedProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'product_id' => $this->product_id,
           'category_id' => $this->category_id,
          'inventory_id' => $this->inventory_id,
          'quantity' => $this->quantity,
          'shipping_place_id' => $this->shipping_place_id,
          'shipping_type' => $this->shipping_type,
          'selling' => $this->selling,
          'shipping_price' => $this->shipping_price,
          'tax_price' => $this->tax_price,
          'bundle_offer' => $this->bundle_offer,
          'order_id' => $this->order_id,
            'product' => new ProductResource($this->product)
        ];
    }
}
