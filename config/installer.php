<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PHP version requirement
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel PHP requirement, you can change
    | it if your application require.
    |
    */
    'core' => [
        'minimumPhpVersion' => '8.1',
        'minimumMysqlVersion' => '5.7',
    ],
    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'gd',
            'zip',
            // 'mcrypt',
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    'verify' => [
        'installed' => env('APP_INSTALL'),
        'install_key' => env('INSTALL_APP_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/app/'              => 775,
        'storage/framework/'        => 775,
        'storage/logs/'             => 775,
        'bootstrap/cache/'          => 775,
        'resources/lang/'           => 777,
        'public/js/lang/'           => 777,
        'Modules'                   => 777,
        '.env'                      => 666,
    ],

    /*
    |--------------------------------------------------------------------------
    | Administrator fields
    |--------------------------------------------------------------------------
    |
    | Set all fields as setted in create method of AuthController
    | Or in rules of form request
    |
    */
    'fields' => [
        'name' => ['type' => 'text', 'name' => 'Name'],
        'email' => ['type' => 'email', 'name' => 'Email'],
        'password' => ['type' => 'password', 'name' => 'Password'],
        'password_confirmation' => ['type' => 'password', 'name' => 'Confirm Password'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Please don't remove the field else the script won't work
    |--------------------------------------------------------------------------
    |
    |
    */
    'item_id' => 'dl9h8fb2rix',

];
