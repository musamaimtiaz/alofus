<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Stripe\Entities;

use Modules\Gateway\Entities\GatewayBody;

class StripeBody extends GatewayBody
{
    public $clientSecret;

    public $publishableKey;

    public $instruction;

    public $status;

    public $sandbox;

    public function __construct($request)
    {
        $this->clientSecret = $request->clientSecret;
        $this->publishableKey = $request->publishableKey;
        $this->instruction = $request->instruction;
        $this->status = $request->status;
        $this->sandbox = $request->sandbox;
    }
}
