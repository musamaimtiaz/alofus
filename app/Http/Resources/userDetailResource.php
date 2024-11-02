<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class userDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'picture_url' => $this->fileUrl(),
            'isImageRemoval' => $this->objectFile()->get()->isNotEmpty() ? 1 : 0,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'address' => $this->address,
            'role' => ['name' => $this->roleUser->roles->name, 'slug' => $this->roleUser->roles->slug],
            'vendor' => ['vendor_info' => optional($this->vendorUser)->vendor, 'shop_info' => optional(optional($this->vendorUser)->vendor)->shop],
            'created_at' => timeZoneFormatDate($this->created_at),
            'updated_at' => timeZoneFormatDate($this->updated_at),
        ];
    }
}
