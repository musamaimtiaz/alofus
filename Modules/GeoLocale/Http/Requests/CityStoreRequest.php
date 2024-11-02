<?php

namespace Modules\GeoLocale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityStoreRequest extends FormRequest
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
            'country_id' => 'required|exists:geolocale_countries,id',
            'division_id' => 'required|exists:geolocale_divisions,id',
            'name' => ['required', 'min:3', 'max:191', Rule::unique('geolocale_cities', 'name')
                ->using(function ($q) { $q->where('division_id', $this->division_id); })],
            'full_name' => 'nullable|min:3|max:191',
            'code' => 'nullable|min:2|max:10',
            'iana_timezone' => 'nullable|min:6|max:100',
        ];
    }
}
