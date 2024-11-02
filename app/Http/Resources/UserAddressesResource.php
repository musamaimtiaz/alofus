<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressesResource extends JsonResource
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
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'company_name' => $this->company_name,
            'type_of_place' => $this->type_of_place,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'city' => $this->city,
            'state' => $this->state,
            'state_name' => optional($this->geoLocalState)->name,
            'zip' => $this->zip,
            'country' => $this->country,
            'country_name' => optional($this->geoLocalCountry)->name,
            'is_default' => $this->is_default == 1 ? true : false,
            'created_at' => timeZoneFormatDate($this->created_at),
        ];
    }
}
