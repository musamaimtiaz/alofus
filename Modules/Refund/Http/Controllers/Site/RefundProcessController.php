<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 25-05-2022
 */

namespace Modules\Refund\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Modules\Refund\Entities\{
    RefundProcess
};
use Modules\Refund\Http\Requests\RefundProcessRequest;

class RefundProcessController extends Controller
{
    /**
     * Store refund process
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function process(RefundProcessRequest $request)
    {
        $this->setSessionValue((new RefundProcess())->store($request->validated()));

        return redirect()->back();
    }
}
