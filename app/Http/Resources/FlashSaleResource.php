<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleResource extends JsonResource
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
            "id" => $this->id,
            "product_id" => $this->product_id ,
            "flash_sale_id" => $this->flash_sale_id,
            "price" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->price : (number_format($this->price / getDollar()->price, 2, '.', '')),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "slug" => $this->slug,
            "title" => $this->title,
            "badge" => $this->badge,
            "selling" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->selling : (number_format($this->selling / getDollar()->price, 2, '.', '')),
            "offered" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->offered : (number_format($this->offered / getDollar()->price, 2, '.', '')),
            "image" => $this->image,
            "review_count" => $this->review_count,
            "rating" => $this->rating
        ];
    }
}
