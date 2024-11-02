<?php

$validation = [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted'             => __('The :xa must be accepted.'),
    'active_url'           => __('The :xa is not a valid URL.'),
    'after'                => __('The :xa must be a date after :xd.'),
    'alpha'                => __('The :xa may only contain letters.'),
    'alpha_dash'           => __('The :xa may only contain letters, numbers, and dashes.'),
    'alpha_num'            => __('The :xa may only contain letters and numbers.'),
    'array'                => __('The :xa must be an array.'),
    'before'               => __('The :xa must be a date before :xd.'),
    'is_old_item_avalilable' => __('Some old products do not have sufficient quantity to transfer!'),
    'is_new_item_avalilable' => __('Some newly added products do not have sufficient quantity!'),
    'is_new_item_adjustable' => __('Some products do not have sufficient quantity to do this adjustment!'),
    'edit_item_adjustable' => __('Some products do not have sufficient quantity to do this adjustment!'),
    'check_quantity' => __('Product Quantity Should Not be Less Than One!'),
    'between'              => [
        'numeric' => __('The :xa must be between :xmn and :xmx.'),
        'file'    => __('The :xa must be between :xmn and :xmx kilobytes.'),
        'string'  => __('The :xa must be between :xmn and :xmx characters.'),
        'array'   => __('The :xa must have between :xmn and :xmx items.'),
    ],
    'boolean'              => __('The :xa field must be true or false.'),
    'confirmed'            => __('The :xa confirmation does not match.'),
    'date'                 => __('The :xa is not a valid date.'),
    'date_format'          => __('The :xa does not match the format :xf.'),
    'different'            => __('The :xa and :xo must be different.'),
    'digits'               => __('The :xa must be :xdi digits.'),
    'digits_between'       => __('The :xa must be between :xmn and :xmx digits.'),
    'distinct'             => __('The :xa field has a duplicate value.'),
    'email'                => __('The :xa must be a valid email address.'),
    'exists'               => __('The selected :xa is invalid.'),
    'filled'               => __('The :xa field is required.'),
    'image'                => __('The :xa must be an image.'),
    'in'                   => __('The selected :xa is invalid.'),
    'in_array'             => __('The :xa field does not exist in :xo.'),
    'integer'              => __('The :xa must be an integer.'),
    'ip'                   => __('The :xa must be a valid IP address.'),
    'json'                 => __('The :xa must be a valid JSON string.'),
    'max'                  => [
        'numeric' => __('The :xa may not be greater than :xmx.'),
        'file'    => __('The :xa may not be greater than :xmx kilobytes.'),
        'string'  => __('The :xa may not be greater than :xmx characters.'),
        'array'   => __('The :xa may not have more than :xmx items.'),
    ],
    'mimes'                => __('The :xa must be a file of type: :xv.'),
    'min'                  => [
        'numeric' => __('The :xa must be at least :xmn.'),
        'file'    => __('The :xa must be at least :xmn kilobytes.'),
        'string'  => __('The :xa must be at least :xmn characters.'),
        'array'   => __('The :xa must have at least :xmn items.'),
    ],
    'not_in'               => __('The selected :xa is invalid.'),
    'numeric'              => __('The :xa must be a number.'),
    'present'              => __('The :xa field must be present.'),
    'regex'                => __('The :xa format is invalid.'),
    'required'             => __('The :xa field is required.'),
    'required_if'          => __('The :xa field is required when :xo is :xvl.'),
    'required_unless'      => __('The :xa field is required unless :xo is in :xv.'),
    'required_with'        => __('The :xa field is required when :xv is present.'),
    'required_with_all'    => __('The :xa field is required when :xv is present.'),
    'required_without'     => __('The :xa field is required when :xv is not present.'),
    'required_without_all' => __('The :xa field is required when none of :xv are present.'),
    'same'                 => __('The :xa and :xo must match.'),
    'size'                 => [
        'numeric' => __('The :xa must be :xs.'),
        'file'    => __('The :xa must be :xs kilobytes.'),
        'string'  => __('The :xa must be :xs characters.'),
        'array'   => 'The :xa must contain :xs items.',
    ],
    'string'               => __('The :xa must be a string.'),
    'timezone'             => __('The :xa must be a valid zone.'),
    'unique'               => __('The :xa has already been taken.'),
    'url'                  => __('The :xa format is invalid.'),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'end_date' => [
            'after_or_equal' => __('The :xa must be greater than or equal to start date.'),
        ],
        'gCaptcha' => [
            'required' => __('Please verify that you are not a robot.'),
            'captcha' => __('Captcha error! try again later or contact site admin.'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

array_walk_recursive($validation, function (&$value) {
    $value = str_replace(
        [':xa', ':xd', ':xmn', ':xf', ':xmx', ':xv', ':xvl', ':xo', ':xs', ':xdi'],
        [':attribute', ':date', ':min', ':format', ':max', ':values', ':value', ':other', ':size', ':digits'],
        $value
    );
});

return $validation;
