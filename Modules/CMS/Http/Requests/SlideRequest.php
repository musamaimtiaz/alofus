<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckValidFile;

class SlideRequest extends FormRequest
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
            'title_text' => 'nullable|max:191',
            'sub_title_text' => 'nullable|max:191',
            'description_title_text' => 'nullable|max:191',
            'title_delay' => 'nullable|between:0,99.99',
            'sub_title_delay' => 'nullable|between:0,99.99',
            'description_title_delay' => 'nullable|between:0,99.99',
            'title_font_size' => 'nullable|numeric',
            'sub_title_font_size' => 'nullable|numeric',
            'description_title_font_size' => 'nullable|numeric',
            'is_open_in_new_window' => 'required|in:Yes,No',
            'image' => ['nullable', new CheckValidFile(getFileExtensions(3))],
        ];
    }
}
