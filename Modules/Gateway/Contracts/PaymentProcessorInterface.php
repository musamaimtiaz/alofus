<?php

namespace Modules\Gateway\Contracts;

interface PaymentProcessorInterface
{
    public function pay(Request $request);
}
