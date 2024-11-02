<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopSellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request = [])
    {
        return [
            'id' => $this->vendor_id,
            'name' => optional($this->vendor)->name,
            'email' => optional($this->vendor)->email,
            'phone' => optional($this->vendor)->phone,
            'status' => optional($this->vendor)->status,
        ];
    }
}
