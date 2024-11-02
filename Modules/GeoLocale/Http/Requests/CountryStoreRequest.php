<?php

namespace Modules\GeoLocale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryStoreRequest extends FormRequest
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
            'continent_id' => 'required',
            'name' => 'required|min:3|max:191|unique:geolocale_countries,name',
            'full_name' => 'nullable|min:3|max:191',
            'capital' => ['nullable', 'regex:/^[a-zA-Z0-9\-\.\' ]*$/'],
            'code' => 'required|min:2|max:2|unique:geolocale_countries,code',
            'code_alpha3' => 'nullable|min:3|max:3|unique:geolocale_countries,code_alpha3',
            'code_numeric' => 'nullable|numeric|digits_between:1,6|unique:geolocale_countries,code_numeric',
            'emoji' => 'nullable|max:16',
            'currency_code' => 'nullable|min:3|max:3',
            'currency_name' => 'nullable|min:3|max:128',
            'currency_symbol' => 'nullable',
            'tld' => 'nullable|max:8|unique:geolocale_countries,tld',
            'callingcode' => 'nullable|numeric|digits_between:1,6',
            'has_division' => 'required|in:0,1',
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
            'has_division.in' => __('The :attribute must be either 0 or 1'),
        ];
    }
}
