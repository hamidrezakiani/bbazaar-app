<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserVoucherResource extends JsonResource
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
            'type'	=> $this->type,
            'status' => $this->status,
            'usage_limit' => $this->usage_limit,
            'limit_per_customer' => $this->limit_per_customer,
            'price' => $request->header('currency') == 'USD' && $this->type == 1 ?
                floatval(number_format($this->price / getDollar()->price, 2)) : $this->price ,
            'min_spend' => $request->header('currency') == 'AFN' ? $this->min_spend
                : floatval(number_format($this->min_spend / getDollar()->price , 2)),
            'code'	=> $this->code,
            'start_time' => $this->start_time,
            'end_time'	=> $this->end_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'capped_price' => $this->capped_price,
            'created' => $this->created,
        ];
    }
}
