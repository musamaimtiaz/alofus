<?php

return [
    'name' => 'Addons',

    'options' => [
        ['label' => 'Settings', 'url' => '#'],
    ],

    // set the route group array
    'route_group' => [
        'prefix' => 'admin',
        'middleware' => [
            'auth', 'locale', 'permission',
        ],
    ],
];
