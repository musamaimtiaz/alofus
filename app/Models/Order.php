<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 14-12-2021
 */

namespace App\Models;

use App\Services\Actions\OrderAction;
use App\Traits\ModelTrait;
use App\Traits\Order\OrderTrait;
use Modules\Commission\Http\Models\OrderCommission;
use Modules\Coupon\Http\Models\CouponRedeem;
use Modules\Gateway\Entities\PaymentLog;
use Validator;

class Order extends Model
{
    use ModelTrait;
    use OrderTrait;

    /**
     * Stores meta information in array
     *
     * @var array
     */
    protected $metaArray = [];

    /**
     * Checks if the meta is already fetched or not
     *
     * @var bool
     */
    protected $metaFetched = false;

    /**
     * Foreign key with currecny model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id');
    }

    /**
     * Foreign key with address model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    /**
     * Foreign key with user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Foreign key with PaymentMethod model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->hasOne('Modules\Gateway\Entities\PaymentLog', 'code', 'reference')->orWhere('id', $this->id);
    }

    /**
     * Foreign key with OrderStatus model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderStatus()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    /**
     * Relation with OrderDetail model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'id')->orderBy('shop_id', 'ASC');
    }

    /**
     * Relation with Transaction model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * Relation with Order note history model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderNoteHistories()
    {
        return $this->hasMany(OrderNoteHistory::class);
    }

    /**
     * Relation with Order note history model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function couponRedeems()
    {
        return $this->hasMany(CouponRedeem::class);
    }

    /**
     * Relation with Order note history model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    /**
     * Relation with Order Meta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(OrderMeta::class, 'order_id', 'id');
    }

    /**
     * Get Vendor Names
     *
     * @param  int  $orderId
     * @return string vendor names
     */
    public function vendorName($orderId)
    {
        $orderDetails = OrderDetail::where('order_id', $orderId)->get();
        $vendorNames = [];

        foreach ($orderDetails as $detail) {
            $vendorName = optional($detail->vendor)->name;

            if (! in_array($vendorName, $vendorNames)) {
                $vendorNames[] = $vendorName;
            }
        }

        return implode(', ', $vendorNames);
    }

    /**
     * Store Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function storeValidation($data = [])
    {
        $validator = Validator::make($data, [
            'address_id' => 'required|exists:addresses,id',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function store($data = [])
    {
        $id = parent::insertGetId($data);
        if (! empty($id)) {
            return $id;
        }

        return false;
    }

    /**
     * Update Order
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function updateOrder($data = [], $id = null)
    {
        $result = parent::where('id', $id)->first();

        if (isset($data['user_id'])) {
            $data['user_id'] = $data['user_id'] == 'Guest' ? null : $data['user_id'];
        }

        if (! empty($result)) {

            if (isset($data['order_status_id'])) {
                $deliveryId = self::getFinalOrderStatus();

                if ($deliveryId == $data['order_status_id']) {
                    $data['is_delivery'] = 1;

                    if (in_array(optional($result->paymentMethod)->gateway, offLinePayments())) {
                        PaymentLog::where('code', $id)->update(['status' => 'completed']);
                    }

                } else {
                    $data['is_delivery'] = 0;
                }
                $orderStatusInfo = OrderStatus::getAll()->where('id', $data['order_status_id'])->first();

                if (strtolower($result->payment_status) != 'paid' && $orderStatusInfo->payment_scenario == 'paid') {
                    $data['payment_status'] = 'Paid';
                    $data['paid'] = $result->total;
                    $data['amount_received'] = $result->total;
                    $result->transactionStore();
                }
            }

            parent::where('id', $id)->update($data);

            return true;
        }

        return false;
    }

    /**
     * Vendor Wise Order Transaction
     *
     * @param  $order
     * @return void
     */
    public function transactionStore()
    {
        $orderDataWithActualPrice = [];
        $orderDataWithDiscountPrice = [];
        $vendorTransactionWithActualPrice = [];
        $vendorTransactionWithDiscountPrice = [];
        $userId = getUserId();

        foreach ($this->orderDetails->groupBy('vendor_id') as $detail) {
            $vendorId = $detail[0]->vendor_id ?? null;
            $totalPrice = $this->vendorProductPrice($vendorId, $this->id) + $this->vendorProductShippingTax($vendorId, $this->id);
            $discount = 0;
            $couponRedeem = CouponRedeem::where('order_id', $this->id);
            if ($couponRedeem->exists()) {
                $discount = $couponRedeem->sum('discount_amount');
            }
            $orderDataWithActualPrice[] = [
                'user_id' => $userId,
                'currency_id' => $this->currency_id,
                'order_id' => $this->id,
                'vendor_id' => $vendorId,
                'shop_id' => $detail[0]->shop_id ?? null,
                'exchange_rate' => optional($this->currency)->exchange_rate,
                'amount' => $totalPrice,
                'paid_amount' => $totalPrice,
                'total_amount' => $totalPrice,
                'transaction_type' => 'Order_actual_price',
                'transaction_date' => now(),
                'status' => 'Accepted',
            ];
            $vendorTransactionWithActualPrice[] = [
                'user_id' => $userId,
                'currency_id' => $this->currency_id,
                'order_id' => $this->id,
                'vendor_id' => $vendorId,
                'shop_id' => $detail[0]->shop_id ?? null,
                'exchange_rate' => optional($this->currency)->exchange_rate,
                'amount' => $totalPrice,
                'paid_amount' => $totalPrice,
                'total_amount' => $totalPrice,
                'reference_number' => $detail[0]->id ?? null,
                'reference_type' => isset($detail[0]) ? 'order_details' : null,
                'transaction_type' => 'Vendor_transaction_actual_price',
                'transaction_date' => now(),
                'status' => 'Accepted',
            ];

            if ($discount > 0) {
                $orderDataWithDiscountPrice[] = [
                    'user_id' => $userId,
                    'currency_id' => $this->currency_id,
                    'order_id' => $this->id,
                    'vendor_id' => $vendorId,
                    'shop_id' => $detail[0]->shop_id ?? null,
                    'exchange_rate' => optional($this->currency)->exchange_rate,
                    'amount' => $totalPrice - $discount,
                    'paid_amount' => $totalPrice - $discount,
                    'total_amount' => $totalPrice - $discount,
                    'discount_amount' => $discount,
                    'transaction_type' => 'Order_discount_price',
                    'transaction_date' => now(),
                    'status' => 'Accepted',
                ];
                $vendorTransactionWithDiscountPrice[] = [
                    'user_id' => $userId,
                    'currency_id' => $this->currency_id,
                    'order_id' => $this->id,
                    'vendor_id' => $vendorId,
                    'shop_id' => $detail[0]->shop_id ?? null,
                    'exchange_rate' => optional($this->currency)->exchange_rate,
                    'amount' => $totalPrice - $discount,
                    'paid_amount' => $totalPrice - $discount,
                    'total_amount' => $totalPrice - $discount,
                    'discount_amount' => $discount,
                    'reference_number' => $detail[0]->id ?? null,
                    'reference_type' => 'order_details',
                    'transaction_type' => 'Vendor_transaction_discount_price',
                    'transaction_date' => now(),
                    'status' => 'Accepted',
                ];
            }
        }
        (new Transaction())->orderTransactionStore($orderDataWithActualPrice);
        (new Transaction())->orderTransactionStore($vendorTransactionWithActualPrice);
        if (count($orderDataWithDiscountPrice) > 0) {
            (new Transaction())->orderTransactionStore($orderDataWithDiscountPrice);
        }
        if (count($vendorTransactionWithDiscountPrice) > 0) {
            (new Transaction())->orderTransactionStore($vendorTransactionWithDiscountPrice);
        }
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $record = parent::find($id);
        if (! empty($record)) {
            try {
                PaymentLog::where('code', $id)->orWhere('code', $record->reference)->delete();
                $record->delete();
                $data['status'] = 'success';
                $data['message'] = __('The :x has been successfully deleted.', ['x' => __('Order')]);
            } catch (Exception $e) {
                $data['message'] = $e->getMessage();
            }
        }

        return $data;
    }

    public static function getOrderReference($typeStr = 'INV')
    {
        $invoice_count = parent::count();

        if ($invoice_count > 0) {
            $invoiceReference = parent::latest('id')
                ->first(['reference']);
            $ref = str_replace($typeStr, '', $invoiceReference->reference);
            $invoice_count = (int) $ref;
        } else {
            $invoice_count = 0;
        }

        $invoice_count = $invoice_count + 1;
        $reference = $typeStr . sprintf('%04d', $invoice_count);

        while (1) {
            $hasOrder = parent::where('reference', $reference);

            if ($hasOrder->exists()) {
                $invoice_count = $invoice_count + 1;
                $reference = $typeStr . sprintf('%04d', $invoice_count);
            } else {
                break;
            }
        }

        return $reference;
    }

    /**
     * totalVendorProduct
     *
     * @return mixed
     */
    public function getTotalVendorProduct($vendorId = null, $orderId = null)
    {
        return OrderDetail::where('vendor_id', $vendorId)->where('order_id', $orderId)->sum('quantity');
    }

    /**
     * payment status
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function paymentStatus($total = 0, $paid = 0)
    {
        $payStatus = __('Unpaid');
        if ($total == $paid) {
            $payStatus = __('Paid');
        } elseif ($paid > 0 && $paid < $total) {
            $payStatus = __('Partially Paid');
        }

        return $payStatus;
    }

    /**
     * vendorProductPrice
     *
     * @return mixed
     */
    public function vendorProductPrice($vendorId = null, $orderId = null)
    {
        if (isActive('Coupon')) {
            $couponRedeem = CouponRedeem::where('order_id', $orderId)->first();
            if (! empty($couponRedeem) && optional($couponRedeem->coupon)->vendor_id == $vendorId) {
                $discountAmount = $couponRedeem->discount_amount;
                $totalAmount = $this->TotalPriceWithQty($vendorId, $orderId);

                return $totalAmount - $discountAmount;
            } else {
                return $this->TotalPriceWithQty($vendorId, $orderId);
            }
        } else {
            return $this->TotalPriceWithQty($vendorId, $orderId);
        }
    }

    /**
     * calculate price with qty
     *
     * @return float|int
     */
    protected function TotalPriceWithQty($vendorId, $orderId)
    {
        $orderDetails = OrderDetail::where('vendor_id', $vendorId)->where('order_id', $orderId)->get();
        $totalAmount = 0;
        foreach ($orderDetails as $detail) {
            $totalAmount += $detail->price * $detail->quantity;
        }

        return $totalAmount;
    }

    /**
     * vendorShippingTaxCalculate
     *
     * @return mixed
     */
    public function vendorProductShippingTax($vendorId = null, $orderId = null)
    {
        $shipping = OrderDetail::where('vendor_id', $vendorId)->where('order_id', $orderId)->sum('shipping_charge');
        $tax = OrderDetail::where('vendor_id', $vendorId)->where('order_id', $orderId)->sum('tax_charge');

        return $shipping + $tax;
    }

    /**
     * vendor order item
     *
     * @return mixed
     */
    public function vendorOrderProduct($vendorId = null, $orderId = null)
    {
        return OrderDetail::where('vendor_id', $vendorId)->where('order_id', $orderId)->get();
    }

    /**
     * order commission
     *
     * @param  $orderId
     * @return void
     */
    public function orderCommission($orderDetailId, $statusId)
    {
        $finalOrderStatus = Order::getFinalOrderStatus();
        $orderCommission = OrderCommission::where('order_details_id', $orderDetailId)->first();
        if (($finalOrderStatus) && $finalOrderStatus == $statusId && ! empty($orderCommission)) {
            (new OrderCommission())->updateOrderCommission(['status' => 'Approve', 'approval_time' => date('Y-m-d H:i:s')], $orderCommission->id);

            $totalAmount = optional($orderCommission->orderDetail)->price * optional($orderCommission->orderDetail)->quantity;
            $totalCommission = ($orderCommission->amount * $totalAmount) / 100;
            /*order transaction*/
            $transactionExists = Transaction::where('transaction_type', 'Vendor_commission')->where('reference_number', optional($orderCommission->orderDetail)->id);
            if (! $transactionExists->exists()) {
                $transaction['user_id'] =  getUserId();
                $transaction['currency_id'] = isset($orderCommission->orderDetail->order->currency_id) ? $orderCommission->orderDetail->order->currency_id : null;
                $transaction['order_id'] = isset($orderCommission->orderDetail->order->id) ? $orderCommission->orderDetail->order->id : null;
                $transaction['exchange_rate'] = isset($orderCommission->orderDetail->order->currency->exchange_rate) ? $orderCommission->orderDetail->order->currency->exchange_rate : null;
                $transaction['vendor_id'] = isset($orderCommission->orderDetail->vendor_id) ? $orderCommission->orderDetail->vendor_id : null;
                $transaction['shop_id'] = isset($orderCommission->orderDetail->shop_id) ? $orderCommission->orderDetail->shop_id : null;
                $transaction['total_amount'] = $totalCommission;
                $transaction['amount'] = $totalCommission;
                $transaction['reference_number'] = optional($orderCommission->orderDetail)->id;
                $transaction['reference_type'] = 'order_details';
                $transaction['transaction_type'] = 'Vendor_commission';
                $transaction['transaction_date'] = now();
                $transaction['status'] = 'Accepted';
                (new Transaction())->store($transaction);
                $transaction['transaction_type'] = 'Admin_commission';
                (new Transaction())->store($transaction);
            } elseif ($transactionExists->exists()) {
                $transactionData = $transactionExists->first();
                $transactionData->status = 'Accepted';
                $transactionData->save();
                (new OrderCommission())->updateOrderCommissionByOrder(['status' => 'Approve', 'approval_time' => date('Y-m-d H:i:s')], $orderDetailId);
            }

            if (isset($orderCommission->orderDetail->vendor)) {
                $orderCommission->orderDetail->vendor->users()->first()->user->wallet()->incrementBalance($totalAmount - $totalCommission);
            }
            /*order transaction*/
        }
    }

    public function TransactionId($orderId = null, $transactionType = 'Order')
    {
        $transaction = Transaction::where('order_id', $orderId)->where('transaction_type', $transactionType)->first();
        if (! empty($transaction)) {
            return $transaction->id;
        }

        return null;
    }

    public function deliveryDate($orderId = null, $statusId = null)
    {
        $orderDetail = OrderStatusHistory::where('order_id', $orderId)->where('order_status_id', $statusId)->whereNull('product_id')->orderBy('id', 'DESC')->first();
        if (! empty($orderDetail)) {
            return $orderDetail->created_at;
        }

        return null;
    }

    /**
     * generate & store pdf
     *
     * @return void
     */
    public function invoicePdfEmail($order = null, $invoiceName = null, $type = 'admin', $vendorId = null)
    {
        if (! empty($order)) {
            $data['orderStatus'] = OrderStatus::getAll()->sortBy('order_by');
            $data['order'] = $order;
            $data['invoiceSetting'] = json_decode(preference('invoice'));
            $data['logo'] = Preference::where('field', 'company_logo')->first()->fileUrl();
            if ($data['invoiceSetting']?->document?->header?->logo == 'logo' && $data['invoiceSetting']?->general->logo) {
                $data['logo'] = Preference::where('field', 'invoice')->first()->fileUrl();
            }
            $data['orderAction'] = new OrderAction();
            $data['user'] = $order->user;
            $data['type'] = 'pdf';
            if ($type == 'admin') {
                $data['orderDetails'] = $order->orderDetails;

                return printPDF($data, public_path() . '/uploads/invoices/' . $invoiceName, 'admin.orders.invoice_print', view('admin.orders.invoice_print', $data), null, 'email');
            } elseif ($type == 'vendor') {
                $data['vendorId'] = $vendorId;
                $data['vendor'] = Vendor::where('id', $vendorId)->first();

                return printPDF($data, public_path() . '/uploads/invoices/' . $invoiceName, 'vendor.orders.invoice_print', view('vendor.orders.invoice_print', $data), null, 'email');
            }
        }

    }

    /**
     * get finalOrder status
     *
     * @return mixed
     */
    public static function getFinalOrderStatus()
    {
        $orderStatus = OrderStatus::getAll()->where('slug', 'completed')->first();

        if (! empty($orderStatus)) {
            return $orderStatus->id;
        }

        return false;
    }

    public static function checkCashOnDelivery($data = null)
    {
        $response = ['status' => false, 'notAvailable' => true];

        if (isset($data['sending_details']->id)) {
            $orderDetails = OrderDetail::select('product_id')->where('order_id', $data['sending_details']->id)->get();
            $productIds = [];

            foreach ($orderDetails as $detail) {
                if (optional($detail->product)->type == 'Variation') {

                    if (isset($detail->product->parent_id) && ! empty($detail->product->parent_id)) {
                        $productIds[] = $detail->product->parent_id;
                    }

                } else {
                    $productIds[] = $detail->product_id;
                }
            }

            $cashDeliveryData = ProductMeta::where('key', 'meta_cash_on_delivery')->whereIn('product_id', $productIds)->pluck('value')->toArray();

            if (count($productIds) == count($cashDeliveryData)) {
                $response = ['status' => true, 'notAvailable' => in_array(0, $cashDeliveryData)];
            } else {
                $response = ['status' => true, 'notAvailable' => true];
            }
        }

        return $response;
    }

    /**
     * check order status
     *
     * @return void
     */
    public function checkOrderStatus()
    {
        if (optional($this->orderStatus)->slug == 'completed') {
            $orderDetails = OrderDetail::where('order_id', $this->order_status_id)->get();

            foreach ($orderDetails as $detail) {
                if (optional($detail->refund)->status != 'Completed' && $detail->is_delivery != 1) {
                    $detailData = ['order_status_id' => $this->order_status_id];
                    $detailData['is_delivery'] = 1;
                    $detailData['is_on_time'] = $detail->isInTime();
                    (new OrderDetail())->updateOrder($detailData, $detail->id);
                    if (isActive('Commission')) {
                        $this->orderCommission($detail->id, $this->order_status_id);
                    }

                    $history['user_id'] = getUserId();
                    $history['product_id'] = $detail->product_id;
                    $history['order_id'] = $this->id;
                    $history['order_status_id'] = $this->order_status_id;
                    (new OrderStatusHistory())->store($history);
                }
            }
        }
    }

    /**
     * vendor discount amount
     *
     * @return int
     */
    public function vendorCouponDiscount($vendorId = null)
    {
        $amount = 0;
        $vendorId = is_null($vendorId) ? auth()->user()->vendor()->vendor_id : $vendorId;

        foreach ($this->couponRedeems as $redeem) {
            $amount += optional($redeem->coupon)->vendor_id == $vendorId ? $redeem->discount_amount : 0;
        }

        return $amount;
    }

    /**
     * vendor payment status
     *
     * @return mixed|string|null
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function vendorPaymentStatus()
    {
        if ($this->paid > 0 && $this->paid != $this->total) {
            $payAbleAmount = $this->vendorProductPrice(session()->get('vendorId'), $this->id) + $this->vendorProductShippingTax(session()->get('vendorId'), $this->id);
            $transactionAmount = Transaction::where([
                ['order_id', $this->id],
                ['vendor_id', session()->get('vendorId')],
                ['transaction_type', 'Order_bulk_payment'],
                ['status', 'Accepted'],
            ])->sum('total_amount');

            if ($payAbleAmount == $transactionAmount) {
                return 'Paid';
            }
        }

        return $this->payment_status;

    }

    /**
     * vendor payable amount
     *
     * @return float|int|mixed
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function vendorPayableAmount()
    {
        $payAbleAmount = $this->vendorProductPrice(session()->get('vendorId'), $this->id) + $this->vendorProductShippingTax(session()->get('vendorId'), $this->id);
        $transactionAmount = Transaction::where([
            ['order_id', $this->id],
            ['vendor_id', session()->get('vendorId')],
            ['transaction_type', 'Order_bulk_payment'],
            ['status', 'Accepted'],
        ])->sum('total_amount');

        if ($transactionAmount > 0) {
            return $payAbleAmount - $transactionAmount;
        }

        return $payAbleAmount;

    }

    public function hasVendorProduct()
    {
        $orderDetail = OrderDetail::where('order_id', $this->id)->whereNotNull('vendor_id')->first();

        if (! empty($orderDetail)) {
            return true;
        }

        return false;
    }
}
