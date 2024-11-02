<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 01-10-2022
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'user' => optional($this->user)->name,
            'currency' => optional($this->currency)->name,
            'symbol' => optional($this->currency)->symbol,
            'balance' => formatCurrencyAmount($this->balance),
            'is_default' => $this->is_default,
            'created' => timeZoneFormatDate($this->created_at) . ' ' . timeZoneGetTime($this->created_at),
            'updated' => timeZoneFormatDate($this->updated_at) . ' ' . timeZoneGetTime($this->updated_at),
        ];
    }
}
