<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = [])
    {
        return [
            'id' => null,
            'rate_code' => null,
            'rate_id' => null,
            'label' => null,
            'compound' => null,
            'tax_total' => null,
            'shipping_tax_total' => null,
        ];
    }
}
