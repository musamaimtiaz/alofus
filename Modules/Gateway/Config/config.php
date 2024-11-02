<?php

return [
    'name' => 'Gateway',

    'logo' => 'http://localhost/multivendor/public/frontend/assets/img/product/logo-4.png',

    'app_name' => env('APP_NAME', 'Martvill'),
    /**
     * Driver for storing temporary purchase details
     *
     * Type: cache || session
     */
    'driver' => 'session',

    /**
     * Name of the currency converter helper function
     * Parameter should be
     */
    'currency_convert' => 'convert_currency',

    /**
     * Cache time for PurchaseDetails Object
     * Value in seconds
     */
    'cache_duration' => 600,

    /**
     * Default payment type
     */
    'payment_type' => 'regular',

    /**
     * Payment types
     */
    'payment_type' => ['regular', 'subscription'],

    /**
     * When please set this name when you are saving success redirect url in session
     */
    'payment_success_route' => 'redirect_url_success',

    'payment_callback' => 'gateway.callback',

    'payment_cancel' => 'gateway.cancel',

];
