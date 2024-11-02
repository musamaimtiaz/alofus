<?php

namespace App\Http\Requests\Site;

use App\Rules\CheckValidEmail;
use App\Rules\CheckValidFile;
use App\Rules\CheckValidPhone;
use App\Rules\StrengthPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Modules\Shop\Http\Models\Shop;

class StoreSellerRequest extends FormRequest
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
            'name'      => ['required', 'min:3', 'max:191'],
            'email'     => ['required', 'max:191', new CheckValidEmail()],
            'password'  => ['required', 'max:191', 'confirmed', new StrengthPassword()],
            'phone'     => ['required', 'min:10', 'max:45', new CheckValidPhone()],
            'logo'      => ['nullable', new CheckValidFile(getFileExtensions(3))],
            'city'      => ['required', 'max:100'],
            'post_code' => ['required', 'max:10'],
            'country'   => ['required', 'max:100'],
            'state'     => ['required', 'max:100'],
            'shop_name' => ['required', 'max:100', 'unique:shops,name'],
            'address'   => ['required', 'max:191'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => __('Email Address'),
            'name' => __('First and last name'),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $alias = Shop::whereAlias($alias = Str::slug($this->f_name . ' ' . $this->l_name))->exists() ? $alias . strtolower(Str::random(4)) : $alias;
        $this->merge([
            'name' => $this->f_name . ' ' . $this->l_name,
            'status' => 'Pending',
            'activation_code' => Str::random(10),
            'activation_otp' => random_int(1111, 9999),
            'alias' => $alias,
        ]);
    }
}
