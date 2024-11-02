<?php

namespace App\Rules;

use App\Models\Language;
use Illuminate\Contracts\Validation\Rule;

class CheckLanguage implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $languageShrotName = Language::getAll()->pluck('short_name', 'id')->toArray();
        if (isset($value)) {
            foreach ($value as $key => $val) {
                if (isset($val['language_id']) && isset($languageShrotName[$val['language_id']]) && $languageShrotName[$val['language_id']] == $key) {
                    continue;
                } else {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Invalid :x', ['x' => __('Language')]);
    }
}
