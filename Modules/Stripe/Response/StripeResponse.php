<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Stripe\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;

class StripeResponse extends Response implements HasDataResponseInterface
{
    protected $response;

    private $data;

    public function __construct($data, $stripeResponse)
    {
        $this->data = $data;
        $this->response = $stripeResponse->jsonSerialize();
        $this->updateStatus();

        return $this;
    }

    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }

    protected function updateStatus()
    {
        if ($this->response['status'] == 'complete') {
            $this->setPaymentStatus('completed');
        } else {
            $this->setPaymentStatus('failed');
        }
    }

    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }

    private function getSimpleResponse()
    {
        return [
            'amount' => $this->response['amount_total'] / 100,
            'amount_captured' => $this->response['amount_total'] / 100,
            'currency' => $this->response['currency'],
            'code' => $this->data->code,
        ];
    }

    public function getGateway(): string
    {
        return 'Stripe';
    }

    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
