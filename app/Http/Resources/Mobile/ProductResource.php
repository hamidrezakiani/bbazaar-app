<?php

namespace App\Http\Resources\Mobile;

use App\Models\Currency;
use App\Models\UserWishlist;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'badge' => 'badge',
            'category_id' => $this->category_id,
            'shipping_rule_id' => $this->shipping_rule_id,
            'unit' => $this->unit,
            'end_time' => $this->end_time,
            'image' =>  $this->image,
            'offered' => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->offered : (number_format($this->offered / getDollar()->price , 2, '.' , '')),
//            "price" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->price : ( $this->price ? number_format($this->price / getDollar()->price, 2, '.', ''): $this->price),
            "price" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->price : ($this->price ? (number_format($this->price / getDollar()->price , 2, '.' , '')) :
                null
            ),
            'rating' => $this->rating,
            'review_count' => $this->review_count,
            'selling' => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->selling : (number_format($this->selling / getDollar()->price, 2, '.', '')),
            'final_price' => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->current_price : (number_format($this->current_price / getDollar()->price, 2, '.', '')),
            'slug' => $this->slug,
            'title' => $this->title,
            'is_favorite' => auth('api')->check() && auth('api')->user()->wishLists()->where('product_id', $this->id)->exists(),
        ];
    }

}
