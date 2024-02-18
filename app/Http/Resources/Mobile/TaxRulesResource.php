<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxRulesResource extends JsonResource
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
            "title" => $this->title,
            "type" => $this->type,
            "price" => $request->header('currency') == 'AFN' ? $this->price : floatval(number_format($this->price / getDollar()->price ,2)),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
