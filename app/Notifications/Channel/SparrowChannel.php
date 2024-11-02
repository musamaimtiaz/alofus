<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class SparrowChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $url = 'http://api.sparrowsms.com/v2/sms/';

        $credential = SmsService::getCredential('sparrow');

        $args = http_build_query([
            'token' => $credential['token'],
            'from' => $credential['from'],
            'to' => $data['to'],
            'text' => $data['message'],
        ]);

        // Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Response
        $response = curl_exec($ch);
        curl_close($ch);

        logger($response);
    }
}
