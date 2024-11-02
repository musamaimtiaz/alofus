<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckEditorText implements Rule
{
    /**
     * Determine if the validation rule passes.
     * As summer note always deliver <p><br></p> tags.
     * This are nedeed only for summer note editor
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return trim(strip_tags($value)) != '';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The text field is required.');
    }
}
