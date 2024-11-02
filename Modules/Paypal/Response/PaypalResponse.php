<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 15-2-22
 */

namespace Modules\Paypal\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;

class PaypalResponse extends Response implements HasDataResponseInterface
{
    protected $response;

    private $data;

    /**
     * Constructor of the response
     *
     * @param  object  $data  (Order data object)
     * @param  object  $response  (Payment response)
     */
    public function __construct($data, $response)
    {
        $this->data = $data;
        $this->response = $response;
        $this->updateStatus();

        return $this;
    }

    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }

    protected function updateStatus()
    {
        if ($this->response->status == 'COMPLETED') {
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
            'amount' => $this->data->total,
            'amount_captured' => $this->response->purchase_units[0]->payments->captures[0]->amount->value,
            'currency' => $this->response->purchase_units[0]->payments->captures[0]->amount->currency_code,
            'code' => $this->data->code,
        ];
    }

    public function getGateway(): string
    {
        return 'paypal';
    }

    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
