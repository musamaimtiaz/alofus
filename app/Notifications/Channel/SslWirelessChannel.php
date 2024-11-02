<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class SslWirelessChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $credential = SmsService::getCredential('sslwireless');

        $params = [
            'api_token' => $credential['api_token'],
            'sid' => $credential['sid'],
            'msisdn' => $data['to'],
            'sms' => $data['message'],
            'csms_id' => date('dmYhhmi') . rand(10000, 99999),
        ];

        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $credential['url']);
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
