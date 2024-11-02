<?php

return [
    'name' => 'Recaptcha',
    'alias' => 'recaptcha',

    // Recaptcha addon settings
    'options' => [
        ['label' => __('Settings'), 'type' => 'modal', 'url' => 'recaptcha.edit'],
        ['label' => __('Recaptcha Documentation'), 'target' => '_blank', 'url' => 'https://www.google.com/recaptcha/admin/create'],
    ],

    /**
     * Recaptcha data validation
     */
    'validation' => [
        'rules' => [
            'siteKey' => 'required|min:30',
            'secretKey' => 'required|min:30',
        ],
        'attributes' => [
            'siteKey' => __('Site Key'),
            'secretKey' => __('Secret Key'),
        ],
    ],
    'fields' => [
        'siteKey' => [
            'label' => __('Site Key'),
            'type' => 'text',
            'required' => true,
        ],
        'secretKey' => [
            'label' => __('Secret Key'),
            'type' => 'text',
            'required' => true,
        ],
    ],

    'store_route' => 'recaptcha.store',

];
