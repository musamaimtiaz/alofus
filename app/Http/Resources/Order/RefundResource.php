<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundResource extends JsonResource
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
            'quantity' => $this->quantity_sent,
            'status' => $this->status,
            'created_at' => timeZoneFormatDate($this->created_at) . ' ' . timeZoneGetTime($this->created_at),
            'updated_at' => timeZoneFormatDate($this->updated_at) . ' ' . timeZoneGetTime($this->updated_at),
        ];
    }
}
