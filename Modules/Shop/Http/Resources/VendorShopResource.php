<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-10-2021
 */

namespace Modules\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorShopResource extends JsonResource
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
            'vendor' => $this->vendor->name,
            'name' => $this->name,
            'email' => $this->email,
            'website' => $this->website,
            'alias' => $this->alias,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'address' => $this->address,
            'description' => $this->description,
            'status' => $this->status,
            'created' => timeZoneFormatDate($this->created_at),
        ];
    }
}
