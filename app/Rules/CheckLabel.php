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

class CheckLabel implements Rule
{
    protected $totalVal;

    protected $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($totalVal = null)
    {
        $this->totalVal = $totalVal;
        $this->message = __('The :x field is invalid.', ['x' => __('Label')]);
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
        if (is_array($value) && count($value) == $this->totalVal) {
            foreach ($value as $label) {
                if (strlen($label) > 0) {
                    if (strlen($label) <= 191) {
                        continue;
                    } else {
                        $this->message = __('The label may not be greater than 191 characters.');

                        return false;
                    }
                } else {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
