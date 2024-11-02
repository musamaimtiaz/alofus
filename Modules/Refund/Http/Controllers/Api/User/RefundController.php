<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 03-04-2022
 */

namespace Modules\Refund\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Modules\Refund\Http\Requests\RefundProcessRequest;
use Modules\Refund\Entities\{
    Refund, RefundProcess, RefundReason
};
use Modules\Refund\Http\Resources\{
    UserRefundDetailResource,
    UserRefundProcessResource
};

class RefundController extends Controller
{
    /**
     * UserRefund List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $configs = $this->initialize([], $request->all());
        $refunds = Refund::where('user_id', auth()->guard('api')->user()->id)->with(['refundReason']);
        if ($refunds->count() == 0) {
            return $this->notFoundResponse([], __('No record found.'));
        }
        $orderId = isset($request->orderId) ? $request->orderId : null;
        if (! empty($orderId)) {
            $refunds->whereHas('orderDetail.order', function ($q) use ($orderId) {
                $q->where('reference', $orderId);
            });
        }

        $status = isset($request->status) ? $request->status : null;
        if (! empty($status)) {
            $refunds->where('status', $status);
        }

        $filter = isset($request->filter) ? $request->filter : null;
        if (! empty($filter)) {
            $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
            if (isset($filter) && array_key_exists($filter, $filterDay)) {
                $refunds->whereDate('created_at', '>=', $filterDay[$filter]);
            }
        }

        $keyword = isset($request->keyword) ? $request->keyword : null;
        if (! empty($keyword)) {
            if (strlen($keyword) >= 3) {
                $refunds->where(function ($query) use ($keyword) {
                    $query->whereHas('orderDetail.order', function ($q) use ($keyword) {
                        $q->whereLike('reference', $keyword);
                    });
                });
            }
        }

        return $this->response([
            'data' => UserRefundDetailResource::collection($refunds->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($refunds->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Get Refund Reasons
     *
     * @return $json data
     */
    public function getReason()
    {
        return $this->response([
            'data' => RefundReason::select('id', 'name')->whereStatus('Active')->get(),
        ]);
    }

    /**
     * Store Refund
     *
     * @return json $response
     */
    public function store(Request $request)
    {
        $response = OrderDetail::find($request->order_detail_id);
        if (! empty($response)) {
            $request['user_id'] = auth()->user()->id;
            $request['refund_type'] = $response->quantity == $request->quantity_sent ? 'Full' : 'Partial';
            $request['refund_method'] = 'Wallet';
            $request['shipping_method'] = 'drop';
            $request['payment_status'] = $response->order->total == $response->order->paid ? 'Paid' : 'Unpaid';
            $request['reference'] = \Str::random(6);
            $request['status'] = 'Opened';

            $validator = Refund::storeValidation($request->all());
            if ($validator->fails()) {
                return $this->unprocessableResponse($validator->messages());
            }

            if ($response->quantity < $request->quantity_sent) {
                return $this->unprocessableResponse(['status' => 'fail', 'message' => __('You exceeded the maximum quantity.')]);
            }

            if ((new Refund())->store($request->all())) {
                return $this->successResponse(['status' => 'success', 'message' => __('Refund request send successfully.')]);
            }
        }

        return $this->errorResponse(['status' => 'fail', 'message' => __('Something went wrong, please try again.')]);
    }

    /**
     * Reason Details
     *
     * @param  int  $id
     * @return json $data
     */
    public function details(Request $request, $id)
    {
        $configs = $this->initialize([], $request->all());
        $refund = Refund::where(['user_id' => auth()->user()->id, 'id' => $id])->with(['refundReason'])->first();
        $refundProcesses = RefundProcess::where(['refund_id' => $id])->orderByDesc('id')->with(['user']);

        if (empty($refund)) {
            return $this->notFoundResponse([], __('Refund not found.'));
        }

        return $this->response([
            'data' => [
                'refund' => new UserRefundDetailResource($refund),
                'chat' => [
                    'data' => UserRefundProcessResource::collection($refundProcesses->paginate($configs['rows_per_page'])),
                    'pagination' => $this->toArray($refundProcesses->paginate($configs['rows_per_page'])->appends($request->all())),
                ],
            ],
        ]);
    }

    /**
     * Get refund message
     *
     * @param  int  $id
     * @return json $response
     */
    public function getMessage(Request $request, $id)
    {
        $configs = $this->initialize([], $request->all());
        $refundProcesses = RefundProcess::where(['refund_id' => $id])->orderByDesc('id')->with(['user']);

        return $this->response([
            'data' => UserRefundProcessResource::collection($refundProcesses->paginate($configs['rows_per_page'])),
            'pagination' => $this->toArray($refundProcesses->paginate($configs['rows_per_page'])->appends($request->all())),
        ]);
    }

    /**
     * Store refund message
     *
     * @return json $response
     */
    public function storeMessage(RefundProcessRequest $request)
    {
        $response = (new RefundProcess())->store($request->validated());
        if ($response['status'] = 'success') {
            return $this->successResponse($response);
        }

        return $this->errorResponse(['status' => 'fail', 'message' => __('Something went wrong, please try again.')]);
    }
}
