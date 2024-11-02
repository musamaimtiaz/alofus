<?php

namespace Modules\Gateway\Contracts;

use Illuminate\Http\Request;

interface RequiresCancelInterface
{
    public function cancel(Request $request);
}
