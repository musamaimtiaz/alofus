<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-02-2022
 */

namespace Modules\Refund\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Modules\Refund\Entities\{
    Refund,
    RefundProcess,
    RefundReason
};

class RefundController extends Controller
{
    /**
     * Refund List
     *
     * @return \Illuminate\Contracts\View
     */
    public function index(Request $request)
    {
        $refunds = Refund::where('user_id', auth()->user()->id)->with(['orderDetail', 'refundReason']);

        $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
        if (isset($request->filter_day) && array_key_exists($request->filter_day, $filterDay)) {
            $refunds->whereDate('created_at', '>=', $filterDay[$request->filter_day]);
        }
        if (isset($request->filter_status) && $request->filter_status != 'All Status') {
            $refunds->where('status', $request->filter_status);
        }

        $data['refunds'] = $refunds->paginate(preference('row_per_page'));
        $data['orders'] = Refund::getOrders();

        return view('refund::site.index', $data);
    }

    /**
     * Store Order Refund
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function refund(Request $request)
    {
        if (! preference('order_refund')) {
            abort(404);
        }

        $response = OrderDetail::find($request->order_detail_id);
        if (! empty($response)) {
            $request['user_id'] = auth()->user()->id;
            $request['refund_type'] = $response->quantity == $request->quantity_sent ? 'Full' : 'Partial';
            $request['refund_method'] = 'Wallet';
            $request['shipping_method'] = 'Drop';
            $request['payment_status'] = $response->order->total == $response->order->paid ? 'Paid' : 'Unpaid';
            $request['reference'] = \Str::random(6);
            $request['status'] = 'Opened';

            $validator = Refund::storeValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if ($response->quantity < $request->quantity_sent) {
                return back()->withErrors(__('You exceeded the maximum quantity.'));
            }

            $this->setSessionValue((new Refund())->store($request->all()));
            if (isset($request->type) && $request->type == 'admin') {
                return redirect()->back();
            }

            return redirect()->route('site.refundRequest');
        }
        $this->setSessionValue(['status' => 'fail', 'message' => __('Something went wrong, please try again.')]);

        return redirect()->back();

    }

    /**
     * Create Refund Request
     *
     * @return \Illuminate\Contracts\View
     */
    public function createRequest()
    {
        if (! preference('order_refund')) {
            abort(404);
        }

        $data['orders'] = Refund::getOrders();
        $data['reasons'] = RefundReason::getAll();

        return view('refund::site.create-refund-request', $data);
    }

    /**
     * Order Refund Details
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View
     */
    public function refundDetails($id = null)
    {
        if (is_null($id)) {
            return redirect()->back()->withErrors(__('Refund not found.'));
        }

        $data['refund'] = Refund::where(['user_id' => auth()->user()->id, 'id' => $id])->with(['orderDetail', 'refundReason'])->first();
        $data['refundProcesses'] = RefundProcess::where(['refund_id' => $id])->with(['user'])->get();
        if (empty($data['refund'])) {
            return redirect()->back()->withErrors(__('Refund not found.'));
        }

        return view('refund::site.refund-details', $data);
    }

    /**
     * Get refund items with order reference
     *
     * @param  string  $reference
     * @return response
     */
    public function getProducts($reference = null)
    {
        return json_encode(Refund::getProducts($reference));
    }
}
