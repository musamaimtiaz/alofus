<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class MsegatChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $credential = SmsService::getCredential('msegat');

        $url = 'https://www.msegat.com/gw/sendsms.php';

        $data = [
            'apiKey' => $credential['api_key'],
            'numbers' => $data['to'],
            'userName' => $credential['user_name'],
            'userSender' => $credential['user_sender'],
            'msg' => $data['message'],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        logger($response);
    }
}
