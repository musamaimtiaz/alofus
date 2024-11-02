<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-08-2021
 * @created 29-09-2021
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'formal_name' => $this->formal_name,
            'total_review' => $this->shopReview()->count,
            'description' => $this->description,
            'rating' => $this->shopReview()->rating,
            'status' => $this->status,
            'website' => $this->website,
            'created_at' => $this->format_created_at,
            'logo' => optional($this->logo)->fileUrl() ?? $this->fileUrl(),
            'cover' => optional($this->cover)->fileUrl() ?? $this->fileUrl(),
        ];
    }
}
