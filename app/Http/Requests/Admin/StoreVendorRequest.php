<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    StrengthPassword,
    CheckValidURL,
    CheckValidPhone,
    CheckValidFile,
    CheckValidEmail
};

class StoreVendorRequest extends FormRequest
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
            'name' => 'required|min:3|max:80|unique:vendors,name',
            'email' => ['required', 'max:99', 'unique:vendors,email,NULL,id,deleted_at,NULL', new CheckValidEmail()],
            'phone' => ['required', 'min:7', 'max:15', 'unique:vendors,phone', new CheckValidPhone()],
            'formal_name' => 'max:99',
            'website' => ['nullable', 'max:191', new CheckValidURL()],
            'status' => 'required|in:Pending,Active,Inactive',
            'sell_commissions' => 'nullable|numeric',
            'logo'  => ['nullable', new CheckValidFile(getFileExtensions(3))],
            'alias' => 'required|unique:shops,alias',
            'address' => 'required|max:191',
            'password' => ['required', new StrengthPassword()],
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
            'status.in' => __('Status must be Active, Inactive or Pending'),
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
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->merge([
            'password' => \Hash::make($this->password),
            'vendor_data' => [
                'vendorData' => $this->only('name', 'email', 'phone', 'formal_name', 'website', 'status', 'sell_commissions'),
                'vendorMetaData' => $this->only('description', 'cover_photo', 'vendor_logo'),
            ],
            'activation_code' => $this->status != 'Active' ? Str::random(10) : null,
        ]);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => $this->dial_code . $this->phone,
        ]);
    }
}
