<?php

namespace Modules\BulkPayment\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\BulkPayment\Services\BulkPaymentService;

class BulkPaymentController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function order(Request $request)
    {
        $bulkPayService = new BulkPaymentService();

        return $bulkPayService->order($request);
    }
}
