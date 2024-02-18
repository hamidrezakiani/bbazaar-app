<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Mobile\ShippingRuleResource;
use App\Http\Resources\Mobile\TaxRulesResource;
class UserCardResource extends JsonResource
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
            'bundle_deal_id' => $this->bundle_deal_id,
            'title' => $this->title,
            'slug' => $this->slug,
            "selling" => $this->offered($request) ?? $this->selling($request) ,
            "offered" => $this->offered($request),
            'tax_rule_id' => $this->tax_rule_id,
            'image' => $this->image,
            'review_count' => $this->review_count,
            'rating' => $this->rating,
            'shipping_rule_id' => $this->shipping_rule_id,
            "price" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->minPrice($this->selling,$this->offered,$this->price) : ($this->minPrice($this->selling,$this->offered,$this->price) ? (number_format($this->minPrice($this->selling,$this->offered,$this->price) / getDollar()->price, 2, '.', '')): null),
            'end_time' => $this->end_time,
            'flash_product' => $this->flash_product,
            'shipping_rule' => new ShippingRuleResource($this->shipping_rule),
            'tax_rules' => new TaxRulesResource($this->tax_rules),
        ];
    }

    private function selling($request)
    {
        return ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->selling : (number_format($this->selling / getDollar()->price, 2, '.' , ''));
    }

    public function offered($request)
    {
        return ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->offered : (number_format($this->offered / getDollar()->price , 2, '.' , ''));
    }

    public function price($request)
    {
        return ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->price : (number_format($this->price / getDollar()->price, 2, '.', ''));
    }

    private function minPrice($selling,$offered,$price){
        return min($selling,$offered,$price);
    }
}
