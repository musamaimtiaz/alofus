<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 21-09-2021
 */

namespace App\Rules;

use App\Models\ProductOption;
use Illuminate\Contracts\Validation\Rule;

class CheckOptionData implements Rule
{
    protected $errorMessage;

    protected $requiredErrorMesssage;

    protected $invalidErrorMesssage;

    protected $errorOptionMaxLength;

    protected $errorMultipleColor;

    protected $errorMultipleSize;

    protected $isInventory;

    protected $itemId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($isInventory = 0, $itemId = null)
    {
        $this->requiredErrorMesssage = __('Required field is mandatory');
        $this->invalidErrorMesssage = __('Invalid :x', ['x' => __('Option')]);
        $this->errorOptionMaxLength = __('The option name may not be greater than 100 characters.');
        $this->errorMultipleColor = __(':x option not more than one', ['x' => __('Color')]);
        $this->errorMultipleSize = __(':x option not more than one', ['x' => __('Size')]);
        $this->isInventory = $isInventory;
        $this->itemId = $itemId;
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
        $requiredValue = [
            'is_required' => [0, 1],
            'type' => labelRequiredElement(),
            'price_type' => ['Fixed', 'Percent'],
            'status' => ['Active', 'Inactive'],
        ];
        $optionField = ['option_name', 'type', 'is_required', 'option_price', 'option_price_type', 'option_status'];
        if ($this->isInventory == 1) {
            $optionField = array_merge($optionField, ['option_qty']);
        }
        $optionNameColor = [];
        $optionNameSize = [];
        if (isset($value)) {
            foreach ($value as $key => $optionValue) {
                if (count(array_diff($optionField, array_keys($optionValue))) == 0) {
                    if (strlen($optionValue['option_name']) > 0 && in_array($optionValue['type'], selectProductForOption()) && in_array($optionValue['is_required'], $requiredValue['is_required'])) {
                        if (strlen($optionValue['option_name']) <= 100) {
                            if ($optionValue['option_name'] == 'Color') {
                                $optionNameColor[] = $optionValue['option_name'];
                            } elseif ($optionValue['option_name'] == 'Size') {
                                $optionNameSize[] = $optionValue['option_name'];
                            }
                            if (count($optionNameColor) <= 1) {
                                if (count($optionNameSize) <= 1) {
                                    if (in_array($optionValue['type'], $requiredValue['type'])) {
                                        if (isset($optionValue['label'])) {
                                            foreach ($optionValue['label'] as $label) {
                                                if (strlen($label) > 0) {
                                                    continue;
                                                } else {
                                                    $this->errorMessage = $this->requiredErrorMesssage;

                                                    return false;
                                                }
                                            }
                                        } else {
                                            $this->errorMessage = $this->invalidErrorMesssage;

                                            return false;
                                        }
                                    }
                                    foreach ($optionValue['option_price'] as $price) {
                                        if (strlen($price) > 0 && preg_match("/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/", $price)) {
                                            continue;
                                        } else {
                                            $this->errorMessage = $this->invalidErrorMesssage;

                                            return false;
                                        }
                                    }
                                    foreach ($optionValue['option_price_type'] as $priceType) {
                                        if (in_array($priceType, $requiredValue['price_type'])) {
                                            continue;
                                        } else {
                                            $this->errorMessage = $this->requiredErrorMesssage;

                                            return false;
                                        }
                                    }
                                    foreach ($optionValue['option_status'] as $optionStatus) {
                                        if (in_array($optionStatus, $requiredValue['status'])) {
                                            continue;
                                        } else {
                                            $this->errorMessage = $this->requiredErrorMesssage;

                                            return false;
                                        }
                                    }
                                    if ($this->isInventory == 1 && isset($optionValue['option_qty'])) {
                                        foreach ($optionValue['option_qty'] as $qty) {
                                            if (strlen($qty) > 0 && preg_match("/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/", $qty) && $qty > 0) {
                                                continue;
                                            } else {
                                                $this->errorMessage = $this->invalidErrorMesssage;

                                                return false;
                                            }
                                        }
                                    }

                                    if (isset($optionValue['item_option_id'])) {
                                        $itemOptionCheck = ProductOption::where('id', $optionValue['item_option_id'])->where('product_id', $this->itemId);
                                        if ($itemOptionCheck->exists()) {
                                            continue;
                                        } else {
                                            $this->errorMessage = $this->invalidErrorMesssage;

                                            return false;
                                        }
                                    }

                                } else {
                                    $this->errorMessage = $this->errorMultipleSize;

                                    return false;
                                }
                            } else {
                                $this->errorMessage = $this->errorMultipleColor;

                                return false;
                            }
                        } else {
                            $this->errorMessage = $this->errorOptionMaxLength;

                            return false;
                        }
                    } else {
                        $this->errorMessage = $this->requiredErrorMesssage;

                        return false;
                    }
                } else {
                    $this->errorMessage = $this->invalidErrorMesssage;

                    return false;
                }
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
        return $this->errorMessage;
    }
}
