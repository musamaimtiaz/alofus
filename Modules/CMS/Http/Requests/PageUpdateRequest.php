<?php

namespace Modules\CMS\Http\Requests;

use App\Rules\CheckValidFile;
use Illuminate\Foundation\Http\FormRequest;

class PageUpdateRequest extends FormRequest
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
        return
            [
                'name' => 'required|min:3|max:150',
                'slug' => ['required', 'min:3', 'max:191', 'unique:pages,slug,' . $this->id],
                'meta_title' => 'nullable|max:150',
                'meta_description' => 'nullable|max:500',
                'status' => 'nullable|in:Active,Inactive',
                'default' => 'nullable|in:1,0',
                'image'  => ['nullable', new CheckValidFile(getFileExtensions(3))],
            ];
    }
}
