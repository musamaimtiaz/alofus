<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingAddressResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'city' => $this->city,
            'state' => $this->state,
            'post_code' => $this->zip,
            'country' => $this->country,
            'type_of_place' => $this->type_of_place,
            'address1' => $this->address_1,
            'address2' => $this->address_2,
            'updated_at' => timeZoneFormatDate($this->updated_at) . ' ' . timeZoneGetTime($this->updated_at),
        ];
    }
}
