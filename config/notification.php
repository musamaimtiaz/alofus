<?php

use App\Notifications\Channel\Fast2SmsChannel;
use App\Notifications\Channel\MimSmsChannel;
use App\Notifications\Channel\MsegatChannel;
use App\Notifications\Channel\NexmoChannel;
use App\Notifications\Channel\SparrowChannel;
use App\Notifications\Channel\SslWirelessChannel;
use App\Notifications\Channel\TwilioChannel;
use App\Notifications\Channel\ZenderChannel;

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration option specifies the default SMS gateway to be used.
    | You can change the value to 'twilio', 'nexmo', or any other supported
    | SMS gateway. The default is ''.
    |
    */

    'default_sms_gateway' => env('SMS_GATEWAY', ''),

    'sms_gateways' => [
        'twilio' => TwilioChannel::class,
        'nexmo' => NexmoChannel::class,
        'fast2sms' => Fast2SmsChannel::class,
        'sslwireless' => SslWirelessChannel::class,
        'mimsms' => MimSmsChannel::class,
        'msegat' => MsegatChannel::class,
        'sparrow' => SparrowChannel::class,
        'zender' => ZenderChannel::class,
    ],

    /*
     * Log items older than this number of days will be automatically be removed.
     *
     * This feature uses Laravel's native pruning feature:
     * https://laravel.com/docs/10.x/eloquent#pruning-models
     */
    'prune_after_days' => 30,

    /*
     * If this is set to true, any notification that does not have a
     * `shouldLog` method will be logged.
     */
    'log_all_by_default' => true,
];
