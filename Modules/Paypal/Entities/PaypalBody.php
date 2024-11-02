<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-2-22
 */

namespace Modules\Paypal\Entities;

use Modules\Gateway\Entities\GatewayBody;

class PaypalBody extends GatewayBody
{
    public $secretKey;

    public $clientId;

    public $instruction;

    public $status;

    public $sandbox;

    public function __construct($request)
    {
        $this->secretKey = $request->secretKey;
        $this->clientId = $request->clientId;
        $this->instruction = $request->instruction;
        $this->sandbox = $request->sandbox;
        $this->status = $request->status;
    }
}
