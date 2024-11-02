<?php

namespace App\Notifications\Channel;

use App\Contract\SmsInterface;
use App\Services\SmsService;

class ZenderChannel implements SmsInterface
{
    /**
     * Send the given notification.
     */
    public function send($data): void
    {
        $credential = SmsService::getCredential('sparrow');

        if (empty($credential['service']) || $credential['service'] < 2) {
            $mode = (! empty($credential['device'])) ? 'devices' : 'credits';

            $params = [
                'secret' => $credential['api_key'],
                'mode' => $mode,
                'phone' => $data['to'],
                'message' => $data['message'],
            ];

            if ($mode == 'devices') {
                $params['device'] = $credential['device'];
                $params['sim'] = ($credential['sim'] < 2) ? 1 : 2;
            } else {
                $params['gateway'] = $credential['gateway'];
            }

            $apiUrl = $credential['site_url'] . '/api/send/sms';
        } else {
            $params = [
                'secret' => $credential['api_key'],
                'account' => $credential['whatsapp'],
                'type' => 'text',
                'recipient' => $data['to'],
                'message' => $data['message'],
            ];

            $apiUrl = $credential['site_url'] . '/api/send/whatsapp';
        }

        $args = http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Response
        $response = curl_exec($ch);
        curl_close($ch);

        logger($response);
    }
}
