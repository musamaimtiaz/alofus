<?php

namespace Modules\BulkPayment\Services;

use Modules\Gateway\Entities\GatewayModule;
use App\Models\{Order, OrderDetail, OrderStatus, Transaction};
use Modules\Gateway\Entities\Gateway;
use DB;

class BulkPaymentService
{
    public function order($request)
    {
        if ($request->isMethod('get')) {
            $orders = Order::whereIn('id', $request->records)->get();
            $data['orders'] = $orders;
            $data['paymentGateways'] = (new GatewayModule())->payableGateways();

            $htmlView = view('bulkpayment::admin.payment_confirm', $data)->render();

            return response()->json([
                'status' => true,
                'html' => $htmlView,
            ]);
        }

        DB::beginTransaction();

        $bulkPaymentNumber = preference('bulk_pay_count');

        if (is_array($request->order_id) && count($request->order_id) > $bulkPaymentNumber) {
            abort('403');
        }

        try {
            foreach ($request->order_id as $key => $orderId) {
                if ($request->paid[$key] > 0) {
                    $partialStatus = OrderStatus::getAll()->where('slug', 'partial-payment')->first();
                    $processingStatus = OrderStatus::getAll()->where('slug', 'processing')->first();
                    $order = Order::where('id', $orderId)->first();

                    if (empty($order)) {
                        return redirect()->back()->withErrors(__('Invalid order!'));
                    }

                    if ($order->payment_status != 'Paid') {

                        if (! is_numeric($request->paid[$key])) {
                            return redirect()->back()->withErrors(__('Invalid paid amount!'));
                        }

                        if (\Route::currentRouteName() == 'bulk.payment.order' && $order->hasVendorProduct() && $request->paid[$key] != ($order->total - $order->paid)) {
                            return redirect()->back()->withErrors(__('Invalid paid amount!'));
                        }

                        if (\Route::currentRouteName() == 'vendor.bulk.payment.order' && $request->paid[$key] > $order->vendorPayableAmount()) {
                            return redirect()->back()->withErrors(__('Invalid paid amount!'));
                        }

                        $paidAmount = $order->amount_received + $request->paid[$key];

                        $order->paid = ($order->paid + $request->paid[$key]);
                        $order->amount_received = $paidAmount;
                        $gateway = Gateway::where('alias', $request->payment_method[$key])->first();

                        $transaction = [
                            'user_id' => getUserId(),
                            'currency_id' => $order->currency_id,
                            'order_id' => $order->id,
                            'vendor_id' => \Route::currentRouteName() == 'vendor.bulk.payment.order' ? auth()->user()->vendor()->vendor_id : null,
                            'exchange_rate' => optional($order->currency)->exchange_rate,
                            'amount' => $request->paid[$key],
                            'paid_amount' => $request->paid[$key],
                            'total_amount' => $request->paid[$key],
                            'transaction_type' => 'Order_bulk_payment',
                            'transaction_date' => DbDateFormat($request->transaction_date[$key]),
                            'reference_type' => ! empty($gateway) ? $gateway->name : null,
                            'reference_number' => $request->transaction_id[$key],
                            'status' => 'Accepted',
                        ];

                        $this->bulkTransaction($transaction);

                        if ($paidAmount != $order->total) {
                            $order->payment_status = 'Partial';

                            if ($order->order_status_id != $partialStatus->id) {
                                $order->order_status_id = $partialStatus->id;

                                foreach ($order->orderDetails as $detail) {
                                    (new OrderDetail())->updateOrder(['order_status_id' => $partialStatus->id], $detail->id);
                                }
                            }
                        }

                        if ($paidAmount > $order->total) {
                            return redirect()->back()->withErrors(__('Invalid paid amount!'));
                        }

                        if ($paidAmount == $order->total) {
                            $order->payment_status = 'Paid';
                            $order->order_status_id = $processingStatus->id;

                            foreach ($order->orderDetails as $detail) {
                                (new OrderDetail())->updateOrder(['order_status_id' => $processingStatus->id], $detail->id);
                            }

                            $order->transactionStore();
                        }

                        $order->save();
                    }

                }
            }
            DB::commit();

            return redirect()->back()->withSuccess(__('Bulk Payment added in successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    protected function bulkTransaction($data = [])
    {
        return (new Transaction())->store($data);
    }
}
