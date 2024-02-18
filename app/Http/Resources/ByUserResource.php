<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ByUserResource extends JsonResource
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
            'id' => $this->id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'order_method' => $this->order_method,
            'currency' => $this->currency,
            'payment_done' => $this->payment_done,
            'cancelled' => $this->cancelled,
            'payment_token' => $this->payment_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'user_address_id' => $this->user_address_id,
            'voucher_id' => $this->voucher_id,
            'order' => $this->order,
            'user_token' => $this->user_token,
            'created' => $this->created,
            'ordered_products' => OrderedProductsResource::collection($this->ordered_products),
        ];
    }
}
