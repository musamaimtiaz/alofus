<?php

namespace App\Services;

use App\Lib\Env;
use App\Models\SmsGateway;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Artisan;

class SmsService
{
    /**
     * Store or update Twilio configuration in the SMS Gateway table.
     *
     * @param  string  $data
     * @param  string  $data
     * @return bool
     */
    public function store(array $data, string $alias, string $title)
    {
        return SmsGateway::updateOrInsert(['alias' => $alias], [
            'name' => $title,
            'alias' => $alias,
            'data' => json_encode($data),
            'status' => 1,
        ]);
    }

    /**
     * Set the default SMS provider based on the given name and value.
     *
     * @param  string  $name  The name of the SMS provider.
     * @param  bool  $value  The value indicating whether to set the SMS provider.
     */
    public function setDefaultProvider($name, $value): void
    {
        $currentGateway = config('notification.default_sms_gateway');

        if ($value && $currentGateway != $name) {
            Env::set('SMS_Gateway', $name);
        }

        if ($currentGateway == $name) {
            Env::set('SMS_Gateway', $value ? $name : '');
        }

        Artisan::call('optimize:clear');
    }

    /**
     * Get credentials from the SMS Gateway table based on the provided alias.
     *
     *
     * @return array
     *
     * @throws ModelNotFoundException
     */
    public static function getCredential(string $alias)
    {
        $response = SmsGateway::firstWhere('alias', $alias)?->data;

        if (empty($response)) {
            throw new ModelNotFoundException('Credential not found.');
        }

        return $response;
    }
}
