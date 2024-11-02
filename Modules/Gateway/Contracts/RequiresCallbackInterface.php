<?php

namespace Modules\Gateway\Contracts;

use Illuminate\Http\Request;

interface RequiresCallbackInterface
{
    public function validateTransaction(Request $request);
}
