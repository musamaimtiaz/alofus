<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 21-06-2022
 */

namespace Modules\GeoLocale\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryDetailResource extends JsonResource
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
            'iso3' => $this->code_alpha3,
            'iso2' => $this->code,
            'phone_code' => $this->callingcode,
            'capital' => $this->capital,
            'currency_code' => $this->currency_code,
            'currency_name' => $this->currency_name,
            'top_level_domain' => $this->tld,
            'emoji' => $this->emoji,
        ];
    }
}
