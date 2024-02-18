<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
          'title' => $this->title,
          'price' => $request->header('currency') == 'USD' && $this->type == 1 ?
              floatval(number_format($this->price / getDollar()->price, 2)) : $this->price ,
          'type' => $this->type,
          'code' => $this->code,
          'min_spend' => $this->min_spend,
          'usage_limit' => $this->usage_limit,
          'limit_per_customer' => $this->limit_per_customer
        ];
    }
}
