<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
            'data' => ProductResource::collection($this->collection),
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'last_page' => $this->lastPage(),
            'current_page' => $this->currentPage(),
        ];
    }

    public function final_price($request,$product) : float
    {
        $flash_sale = ($request->header('currency') ?? 'AFN') == 'AFN' ? $product->price : (number_format($product->price / getDollar()->price, 2, '.', ''));
        $offered = (($request->header('currency') ?? 'AFN') == 'AFN' ? $product->offered : number_format($product->offered / getDollar()->price, 2, '.', ''));
        $selling = ($request->header('currency') ?? 'AFN') == 'AFN' ? $product->selling : (number_format($product->selling / getDollar()->price, 2, '.', ''));
        return $flash_sale ?? ($offered ?? $selling);
    }

    public function paginationInformation($request, $paginated, $default)
    {
        $default['links']['custom'] = 'https://example.com';

        return $default;
    }
}
