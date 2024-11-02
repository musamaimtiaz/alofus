<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class NexmoChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $url = 'https://rest.nexmo.com/sms/json';

        $credential = SmsService::getCredential('nexmo');

        $params = [
            'api_key' => $credential['api_key'],
            'api_secret' => $credential['api_secret'],
            'from' => $credential['from'],
            'text' => $data['message'],
            'to' => $data['to'],
        ];

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json',
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        logger($response);
    }
}
