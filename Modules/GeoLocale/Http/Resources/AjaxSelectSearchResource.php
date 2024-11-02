<?php

namespace Modules\GeoLocale\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AjaxSelectSearchResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->currency_code,
            'text' => $this->currency_code,
        ];
    }
}
