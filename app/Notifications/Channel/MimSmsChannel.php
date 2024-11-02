<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class MimSmsChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $credential = SmsService::getCredential('mimsms');

        $url = $credential['base_url'] . '/smsapi';

        $data = [
            'api_key' => $credential['api_key'],
            'type' => 'text',
            'contacts' => $data['to'],
            'senderid' => $credential['sender_id'],
            'msg' => $data['message'],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        logger($response);
    }
}
