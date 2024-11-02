<?php

namespace Modules\Gateway\Contracts;

interface CryptoResponseInterface
{
    /**
     * Retrieve payment url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set necessary values which are needed for webhook callback
     *
     * @param array
     */
    public function setParams($array);

    /**
     * Get necessary values which are needed for webhook callback
     */
    public function getParams();

    /**
     * Set a unique code returned by the gateway while creating payment request/transaction
     */
    public function setUniqueCode($code);

    /**
     * get a unique code
     *
     * @return string
     */
    public function getUniqueCode();
}
