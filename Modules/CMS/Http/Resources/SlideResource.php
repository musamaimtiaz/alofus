<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 01-10-2022
 */

namespace Modules\CMS\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request = [])
    {
        return [
            'id' => $this->id,
            'title_text' => $this->title_text,
            'title_animation' => $this->title_animation,
            'title_delay' => $this->title_delay,
            'title_font_color' => $this->title_font_color,
            'title_font_size' => $this->title_font_size,
            'title_direction' => $this->title_direction,
            'sub_title_text' => $this->sub_title_text,
            'sub_title_animation' => $this->sub_title_animation,
            'sub_title_delay' => $this->sub_title_delay,
            'sub_title_font_color' => $this->sub_title_font_color,
            'sub_title_font_size' => $this->sub_title_font_size,
            'sub_title_direction' => $this->sub_title_direction,
            'description_title_text' => $this->description_title_text,
            'description_title_animation' => $this->description_title_animation,
            'description_title_delay' => $this->description_title_delay,
            'description_title_font_color' => $this->description_title_font_color,
            'description_title_font_size' => $this->description_title_font_size,
            'description_title_direction' => $this->description_title_direction,
            'button_title' => $this->button_title,
            'button_link' => $this->button_link,
            'button_position' => $this->button_position,
            'is_open_in_new_window' => $this->is_open_in_new_window,
            'image' => $this->fileUrl(),
            'created' => timeZoneFormatDate($this->created_at) . ' ' . timeZoneGetTime($this->created_at),
            'updated' => timeZoneFormatDate($this->updated_at) . ' ' . timeZoneGetTime($this->updated_at),
        ];
    }
}
