<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 21-09-2021
 */

namespace App\Rules;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CategoryAttribute;
use Illuminate\Contracts\Validation\Rule;

class CheckAttribute implements Rule
{
    protected $category;

    protected $errorMessage;

    protected $attributeErrorMessage;

    protected $attributeValueErrorMessage;

    protected $attributeRequired;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($category_id = null)
    {
        $this->category = $category_id;
        $this->attributeErrorMessage = __('Invalid :x', ['x' => __('Attribute')]);
        $this->attributeValueErrorMessage = __('The selected :x is invalid.', ['x' => __('Attribute Value')]);
        $this->attributeRequired = __(':x is required.', ['x' => __('Attribute')]);
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
        $requiredAttribute = CategoryAttribute::select('attribute_id')->distinct()->where('category_id', $this->category)->WhereHas('attribute', function ($query) {
            $query->where('status', 'Active');
            $query->where('is_required', 1);
        })->with('attribute')->pluck('attribute_id')->toArray();
        if (! empty($requiredAttribute)) {
            if (count(array_diff($requiredAttribute, array_keys($value))) == 0) {
                $categoryAttribute = CategoryAttribute::select('attribute_id')->distinct()->where('category_id', $this->category)->WhereHas('attribute', function ($query) {
                    $query->where('status', 'Active');
                })->with('attribute')->pluck('attribute_id')->toArray();
                foreach ($categoryAttribute as $attr) {
                    $attributeDetails = Attribute::getAll()->where('id', $attr)->first();
                    $categoryAttributeRequired[$attributeDetails->id] = $attributeDetails->is_required;
                    $categoryAttributeType[$attributeDetails->id] = $attributeDetails->type;
                }
                $attributeValue = AttributeValue::getAll()->whereIn('attribute_id', $categoryAttribute)->pluck('value')->toArray();
                foreach ($value as $key => $attribute) {
                    if (in_array($key, $categoryAttribute)) {
                        if ($categoryAttributeRequired[$key] == 1) {
                            if ($this->checkAttributeValue($categoryAttributeType[$key], $attribute, $attributeValue) == true) {
                                continue;
                            } else {
                                return false;
                            }
                        } elseif ($categoryAttributeRequired[$key] == 0) {
                            if ($this->checkAttributeValue($categoryAttributeType[$key], $attribute, $attributeValue, false) == true) {
                                continue;
                            } else {
                                return false;
                            }
                        } else {
                            $this->errorMessage = $this->attributeErrorMessage;

                            return false;
                        }
                    } else {
                        $this->errorMessage = $this->attributeErrorMessage;

                        return false;
                    }
                }

                return true;
            } else {
                $this->errorMessage = $this->attributeRequired;

                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Check Attribute Value
     *
     * @param  null  $type
     * @param  null  $attribute
     * @param  array  $attributeValue
     * @param  bool  $required
     * @return bool|void
     */
    public function checkAttributeValue($type = null, $attribute = null, $attributeValue = [], $required = true)
    {
        if ($type != 'field') {
            if ($type == 'multiple_select') {
                if ($required == true && count($attribute) == 0) {
                    $this->errorMessage = $this->attributeRequired;

                    return false;
                } else {
                    foreach ($attribute as $multipleAttributeValue) {
                        if (in_array($multipleAttributeValue, $attributeValue)) {
                            return true;
                        } else {
                            $this->errorMessage = $this->attributeValueErrorMessage;

                            return false;
                        }
                    }
                }
            } elseif ($required == true && strlen($attribute) == 0) {
                $this->errorMessage = $this->attributeRequired;

                return false;
            } elseif (strlen($attribute) > 0 && in_array($attribute, $attributeValue)) {
                return true;
            } elseif ($required == false) {
                if (strlen($attribute) > 0) {
                    if (in_array($attribute, $attributeValue)) {
                        return true;
                    }
                    $this->errorMessage = $this->attributeValueErrorMessage;

                    return false;
                } else {
                    return true;
                }
            } else {
                $this->errorMessage = $this->attributeValueErrorMessage;

                return false;
            }
        }
        if ($required == true && $type == 'field') {
            if (strlen($attribute) > 0) {
                return true;
            } else {
                $this->errorMessage = $this->attributeRequired;

                return false;
            }
        } else {
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
        return $this->errorMessage;
    }
}
