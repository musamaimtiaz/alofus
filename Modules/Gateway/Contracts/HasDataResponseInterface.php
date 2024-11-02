<?php

namespace Modules\Gateway\Contracts;

interface HasDataResponseInterface
{
    /**
     * Every method should return json_encoded array
     */

    /**
     * Returns raw response provided by the gateway
     */
    public function getRawResponse(): string;

    /**
     * Returns array of formatted response
     *
     * array([
     * 'amount' => 1234
     * 'currency' => 'usd'
     * ])
     */
    public function getResponse(): string;
}
