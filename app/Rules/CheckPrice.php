<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 21-09-2021
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckPrice implements Rule
{
    protected $chckType;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type = 'multiple')
    {
        $this->chckType = $type;
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
        if ($this->chckType == 'multiple') {
            foreach ($value as $price) {
                $price = validateNumbers($price);
                if (preg_match("/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/", $price)) {
                    continue;
                } else {
                    return false;
                }
            }

            return true;
        } else {
            $value = validateNumbers($value);
            if (preg_match("/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/", $value)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The selected :x is invalid.', ['x' => __('Price')]);
    }
}
