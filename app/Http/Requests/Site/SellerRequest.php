<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckValidPhone;
use Illuminate\Support\Facades\Auth;

class SellerRequest extends FormRequest
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
            'phone'       => ['required', 'min:10', 'max:45', new CheckValidPhone()],
            'formal_name' => 'max:99',
            'alias'       => 'required|unique:shops,alias',
            'email'       => 'required|unique:vendors,email',
            'shop_name'   => 'required|min:3|max:191|unique:shops,name',
            'address'     => 'required|max:191',
            'description' => 'required|min:3|max:191',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'status' => 'Pending',
            'name'   => Auth::user()->name,
            'phone'  => $this->phone ?? Auth::user()->phone,
            'email'  => Auth::user()->email,
        ]);
    }
}
