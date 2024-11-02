<?php

/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-06-2022
 */

namespace Modules\CashOnDelivery\Processor;

use Modules\Gateway\Contracts\PaymentProcessorInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\CashOnDelivery\Response\CashOnDeliveryResponse;

class CashOnDeliveryProcessor implements PaymentProcessorInterface
{
    private $token;

    private $secret;

    private $key;

    private $helper;

    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
    }

    /**
     * Handles payment for stripe
     *
     * @param \Illuminate\Http\Request
     * @return CashOnDeliveryResponse
     */
    public function pay($request)
    {

        $this->data = $this->helper->getPurchaseData($this->key);

        $charge = [
            'status' => 'succeeded',
            'amount' => $this->data->total,
            'currency' => $this->data->currency_code,
        ];

        return new CashOnDeliveryResponse($this->data, $charge);
    }
}
