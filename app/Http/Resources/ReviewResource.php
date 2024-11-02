<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'image' => $this->reviewImages(),
            'product_name' => optional($this->product)->name,
            'product_image' => $this->product->getFeaturedImage(),
            'user_name' => optional($this->user)->name,
            'user_image' => $this->user->fileUrl(),
            'comments' => $this->comments,
            'rating' => $this->rating,
            'status' => $this->status == 'Active' && $this->is_public == '1' ? 'Approve' : 'Unapprove',
            'created_at' => timeZoneFormatDate($this->created_at),
        ];
    }
}
