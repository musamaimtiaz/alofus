<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = [])
    {
        $pictureURL  = url('public/dist/img/default-image.png');
        $pictureName = 'default-image.png';
        if (isset($this->image->file_name) && ! empty($this->image->file_name) && file_exists('public/uploads/brand/' . $this->image->file_name)) {
            $pictureURL  = url('public/uploads/brand/' . $this->image->file_name);
            $pictureName = $this->image->file_name;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'vendor' => optional($this->vendor)->name,
            'status' => $this->status,
            'created_at' => $this->format_created_at,
            'picture_name' => $pictureName,
            'picture_url' => $pictureURL,
        ];
    }
}
