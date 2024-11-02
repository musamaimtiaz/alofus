<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 26-10-2021
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            'attribute_group' => optional($this->attributeGroup)->name,
            'category' => optional($this->category)->name,
            'explain' => $this->explain,
            'type' => ucwords(str_replace('_', ' ', $this->type)),
            'status' => $this->status,
            'is_required' => $this->is_required == 1 ? __('Yes') : __('No'),
            'is_filterable' => $this->is_filterable == 1 ? __('Yes') : __('No'),
            'created_at' => $this->format_created_at,
        ];
    }
}
