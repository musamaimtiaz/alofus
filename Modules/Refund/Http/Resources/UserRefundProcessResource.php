<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 26-07-2022
 */

namespace Modules\Refund\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRefundProcessResource extends JsonResource
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
            'user_name' => optional($this->user)->name,
            'user_type' => (auth()->user()->role()->name == $this->user->role()->name) ? __('You') : $this->user->role()->name,
            'message' => $this->note,
            'image' => optional($this->user)->fileUrl(),
            'created_at' => timeZoneFormatDate($this->created_at) . ' ' . timeZoneGetTime($this->created_at),
        ];
    }
}
