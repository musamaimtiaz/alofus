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

class CheckAttributeValue implements Rule
{
    protected $message;

    protected $type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type = null)
    {
        $this->type = $type;
        $this->message = __(':x is required', ['x' => __('Attribute Value')]);
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
        $allValue = $value;
        foreach ($value as $val) {
            if (strlen($val) > 0) {
                if (strlen($val) <= 50) {
                    if (count(array_keys($allValue, $val)) > 1) {
                        $this->message = __('Duplicate Attribute value entry error!');

                        return false;
                    }
                } else {
                    $this->message = __('The value may not be greater than 50 characters.');

                    return false;
                }
            } elseif ($this->type == 'field') {
                continue;
            } else {
                return false;
            }
        }

        return true;
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
