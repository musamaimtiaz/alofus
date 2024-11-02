<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckValidFile;

class BlogRequest extends FormRequest
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
            'category_id' => 'required',
            'title' => 'required|max:191',
            'slug' => 'required|max:191',
            'status' => 'required|in:Active,Inactive',
            'description' => 'required',
            'summary' => 'required|max:191',
            'image'  => ['nullable', new CheckValidFile(getFileExtensions(3))],
        ];
    }
}
