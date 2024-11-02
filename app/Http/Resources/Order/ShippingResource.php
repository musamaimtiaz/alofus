<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
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
            'method_title' => null,
            'method_id' => null,
            'total' => null,
            'total_tax' => null,
            'taxes' => [],
        ];
    }
}
