<?php

namespace Modules\Gateway\Response;

abstract class Response
{
    protected $status = 'pending';

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the name of the gateway
     */
    abstract public function getGateway(): string;

    /**
     * Update protected $status value depending of the payment result
     * pending | successful | failed
     */
    abstract protected function setPaymentStatus($status);
}
