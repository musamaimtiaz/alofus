<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
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
            'id' => $this->id,
            'created_at' => timeZoneFormatDate($this->created_at) . ' ' . timeZoneGetTime($this->created_at),
            'line_items' => new ProductResource($this->product),
        ];
    }
}
