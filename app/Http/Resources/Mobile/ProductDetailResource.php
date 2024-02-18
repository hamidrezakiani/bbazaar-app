<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\Mobile\VoucherResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'overview' => $this->overview,
            'unit' => $this->unit,
            'badge' => $this->badge,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'tags' => $this->tags,
            "selling" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->selling : (number_format($this->selling / getDollar()->price, 2, '.' , '') )  ,
            "offered" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->offered : ( number_format($this->offered / getDollar()->price , 2, '.' , '')),
            'purchased' => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->selling : (number_format($this->selling / getDollar()->price, 2, '.', '')),
            'image' => $this->image,
            'video' => $this->video,
            'video_thumb' => $this->video_thumb,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'warranty' => $this->warranty,
            'refundable' => $this->refundable,
            'tax_rule_id' => $this->tax_rule_id,
            'shipping_rule_id' => $this->shipping_rule_id,
            'review_count' => $this->review_count,
            'rating' => $this->rating,
            'bundle_deal_id' => $this->bundle_deal_id,
            'brand_id' => $this->brand_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'admin_id' => $this->admin_id,
            'slug' => $this->slug,
            "price" => ($request->header('currency') ?? 'AFN') == 'AFN' ? $this->price : (number_format($this->price / getDollar()->price, 2, '.', '')),
            'end_time' => $this->end_time,
            'wishlisted' => $this->wishlisted,
            'inventory' => $this->inventory,
            'vouchers' => VoucherResource::collection($this->vouchers),
            'self_slug' => $this->self_slug,
            'time_zone' => $this->time_zone,
            'in_stock' => $this->in_stock,
            'attribute' => $this->attribute,
            'is_favorite' => auth('api')->check() && auth('api')->user()->wishLists()->where('product_id', $this->id)->exists(),
            'brand' => $this->brand,
            'store' => $this->store,
            'bundle_deal' => $this->bundle_deal,
            'current_categories' => $this->current_categories,
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'product_image_names' => $this->product_image_names,
            'shipping_rule' => $this->shipping_rule
        ];

    }
}
