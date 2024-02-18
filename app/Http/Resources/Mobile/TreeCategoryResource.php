<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class TreeCategoryResource extends JsonResource
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
            'title' => $this->title,
            'image' => 'thumb-' . $this->image,
            'slug' => $this->slug,
            'products_count' => $this->products()->public()->count(),
            'sub_categories' => TreeSubCategoryResource::collection($this->sub_categories)
        ];
    }
}
