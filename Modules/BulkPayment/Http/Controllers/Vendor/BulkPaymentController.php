<?php

namespace Modules\BulkPayment\Http\Controllers\Vendor;

use App\Models\Order;
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

        $orderIds = isset($request->records) ? $request->records : $request->order_id;

        foreach ($orderIds as $id) {
            $order = Order::where('id', $id)->first();
            $vendorId = $order->orderDetails->pluck('vendor_id')->toArray();

            if (empty($order) && ! in_array(auth()->user()->vendor()->vendor_id, $vendorId)) {
                abort(403);
            }
        }

        return $bulkPayService->order($request);
    }
}
