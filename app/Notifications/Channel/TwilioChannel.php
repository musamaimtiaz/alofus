<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class TwilioChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $credential = SmsService::getCredential('twilio');

        $url = "https://api.twilio.com/2010-04-01/Accounts/{$credential['account_sid']}/Messages.json";

        $data = [
            'To' => $data['to'],
            'From' => $credential['twilio_number'],
            'Body' => $data['message'],
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_USERPWD => "{$credential['account_sid']}:{$credential['auth_token']}",
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            logger($error);
        }
    }
}
