<?php

return [
    'name' => 'Addons',

    'options' => [
        ['label' => 'Settings', 'url' => '#'],
    ],

    // set the route group array
    'route_group' => [
        'prefix' => 'admin',
        'namespace' => 'Modules\Addons\Http\Controllers',
        'middleware' => [
            'guest:admin', 'locale', 'web',
        ],
    ],
];
