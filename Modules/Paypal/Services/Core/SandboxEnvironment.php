<?php

namespace Modules\Paypal\Services\Core;

class SandboxEnvironment extends PayPalEnvironment
{
    public function __construct($clientId, $clientSecret)
    {
        parent::__construct($clientId, $clientSecret);
    }

    public function baseUrl()
    {
        return 'https://api-m.sandbox.paypal.com';
    }
}
