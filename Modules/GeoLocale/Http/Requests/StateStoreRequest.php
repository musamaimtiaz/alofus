<?php

namespace Modules\GeoLocale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StateStoreRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:191', Rule::unique('geolocale_divisions', 'name')
                ->using(function ($q) { $q->where('country_id', $this->country_id); })],
            'full_name' => 'nullable|min:3|max:191',
            'code' => 'required|min:2|max:10',
            'has_city' => 'required|in:0,1',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'has_city.in' => __('The :attribute must be either 0 or 1'),
        ];
    }
}
