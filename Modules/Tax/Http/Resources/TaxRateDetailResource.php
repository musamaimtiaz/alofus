<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-07-2022
 */

namespace Modules\Tax\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxRateDetailResource extends JsonResource
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
            'country' => $this->country,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'rate' => formatNumber($this->tax_rate),
            'name' => $this->name,
            'priority' => $this->priority,
            'compound' => $this->compound,
            'shipping' => $this->shipping,
            'class' => optional($this->taxClass)->name,
        ];
    }
}
