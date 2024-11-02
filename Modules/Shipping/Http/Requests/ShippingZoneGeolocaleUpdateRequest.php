<?php

namespace Modules\Shipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingZoneGeolocaleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country' => 'nullable|max:30',
            'state' => 'nullable|max:30',
            'city' => 'nullable|max:30',
            'zip' => 'nullable|max:10',
            'shipping_zone_id' => 'required|exists:shipping_zones,id',
        ];
    }
}
