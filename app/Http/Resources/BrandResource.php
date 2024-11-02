<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'vendor' => optional($this->vendor)->name,
            'status' => $this->status,
            'created_at' => $this->format_created_at,
            'image' => $this->fileUrl(),
        ];
    }
}
