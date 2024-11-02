<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 27-10-2021
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailResource extends JsonResource
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
            'slug' => $this->slug,
            'parent' => ['id' => $this->parent_id, 'name' => optional($this->category)->name],
            'order_by' => $this->order_by,
            'status' => $this->status,
            'is_searchable' => $this->is_searchable == 1 ? __('Yes') : __('No'),
            'created_at' => $this->format_created_at,
            'picture_url' => $this->fileUrl(),
        ];
    }
}
