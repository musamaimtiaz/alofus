<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 06-08-2022
 */

namespace Modules\CashOnDelivery\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;

class CashOnDeliveryResponse extends Response implements HasDataResponseInterface
{
    protected $response;

    private $data;

    public function __construct($data, $codResponse)
    {
        $this->data = $data;
        $this->response = $codResponse;
        $this->updateStatus();

        return $this;
    }

    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }

    protected function updateStatus()
    {
        if ($this->response['status'] == 'succeeded') {
            $this->setPaymentStatus('pending');
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
            'amount' => $this->response['amount'] / 100,
            'amount_captured' => 0,
            'currency' => $this->response['currency'],
            'code' => $this->data->code,
        ];
    }

    public function getGateway(): string
    {
        return 'CashOnDelivery';
    }

    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
