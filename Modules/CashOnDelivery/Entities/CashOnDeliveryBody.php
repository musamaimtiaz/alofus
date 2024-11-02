<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\CashOnDelivery\Entities;

use Modules\Gateway\Entities\GatewayBody;

class CashOnDeliveryBody extends GatewayBody
{
    public $status;

    public function __construct($request)
    {
        $this->instruction = $request->instruction;
        $this->status = $request->status;
    }
}
