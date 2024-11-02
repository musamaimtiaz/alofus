<?php

namespace Modules\Gateway\Contracts;

interface RequiresWebHookValidationInterface
{
    public function validatePayment(\Illuminate\Http\Request $request);
}
