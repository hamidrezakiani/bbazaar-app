<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingPlacesResource extends JsonResource
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
            'id' => $this?->id,
            'country' => $this?->country,
            'state' => $this?->state,
            'price' => $request->header('currency') == "USD" ? number_format($this?->price / getDollar()->price, 2) : $this?->price,
            'day_needed' => $this?->day_needed,
            'pickup_price' => $request->header('currency') == "USD" ? number_format($this?->pickup_price / getDollar()->price,2) : $this?->pickup_price,
            'pickup_point' => $this?->pickup_point,
            'shipping_rule_id' => $this?->shipping_rule_id
        ];
    }
}
