<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class Fast2SmsChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $credential = SmsService::getCredential('fast2sms');

        if (strpos($data['to'], '+91') !== false) {
            $data['to'] = substr($data['to'], 3);
        }

        $fields = [
            'message' => $data['message'],
            'route' => $credential['route'],
            'numbers' => $data['to'],
            'flash' => '1',
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://www.fast2sms.com/dev/bulkV2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => [
                'authorization: ' . $credential['api_key'],
                'accept: */*',
                'cache-control: no-cache',
                'content-type: application/json',
            ],
        ]);

        curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            logger('cURL Error #:' . $err);
        }
    }
}
