<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 29-05-2021
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'role' => ['name' => $this->roleUser->roles->name, 'slug' => $this->roleUser->roles->slug],
            'vendor' => ['vendor_info' => optional($this->vendorUser)->vendor, 'shop_info' => optional(optional($this->vendorUser)->vendor)->shop],
            'address' => UserAddressesResource::collection($this->addresses),
            'created_at' => $this->format_created_at,
        ];
    }
}
