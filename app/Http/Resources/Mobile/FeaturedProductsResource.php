<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedProductsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "product_collection_id" => $this->product_collection_id,
            "product_id" => $this->product_id,
            "title" => $this->title,
            "badge" => $this->badge,
            "selling" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->selling : (number_format($this->selling / getDollar()->price, 2, '.' , '')),
            "offered" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->offered : (number_format($this->offered / getDollar()->price , 2, '.' , '')),
            "slug" => $this->slug,
            "image" => $this->image,
            "review_count" => $this->review_count,
            "rating" => $this->rating,
            "shipping_rule_id" => $this->shipping_rule_id,
            "price" =>  ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->price : (number_format($this->price / getDollar()->price , 2, '.' , '')),
            "end_time" => $this->end_time
        ];
    }
}
