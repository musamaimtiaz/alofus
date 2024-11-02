<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-02-2022
 */

namespace Modules\Refund\Entities;

use App\Traits\ModelTraits\hasFiles;
use App\Models\{
    Inventory,
    Model,
    OrderDetail,
    Transaction,
    User
};
use Validator;
use Auth;

class Refund extends Model
{
    use hasFiles;

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relation with User model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation with OrderDetail model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    /**
     * Relation with RefundReason model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refundReason()
    {
        return $this->belongsTo(RefundReason::class);
    }

    /**
     * Relation with RefundProcess model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function refundProcesses()
    {
        return $this->hasMany(RefundProcess::class);
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
            'order_detail_id' => 'required|exists:order_details,id',
            'refund_reason_id' => 'required|exists:refund_reasons,id',
            'quantity_sent' => 'required|numeric',
            'refund_type' => 'required|in:Full,Partial',
            'refund_method' => 'required|in:Wallet',
            'shipping_method' => 'required',
            'payment_status' => 'required|in:Paid,Unpaid',
            'status' => 'required|in:Opened,In progress,Accepted,Declined',
        ], [
            'status.in' => __('Refund status must be Opened, In progress, Accepted or Declined.'),
        ]);

        return $validator;
    }

    /**
     * Update Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function updateValidation($data = [])
    {
        $validator = Validator::make($data, [
            'status' => 'required|in:Opened,In progress,Accepted,Declined',
        ], [
            'status.in' => __('Refund status must be Opened, In progress, Accepted or Declined.'),
        ]);

        return $validator;
    }

    /**
     * Store Refund
     *
     * @param  array  $data
     * @return array $response
     */
    public function store($data)
    {
        $response = ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $refund = parent::where(['user_id' => $data['user_id'], 'order_detail_id' => $data['order_detail_id']])->first();
        if (! empty($refund) && ($refund->quantity_sent + $data['quantity_sent']) > $refund->orderDetail->quantity) {
            $response['message'] = __('You have exceeded product quantity limit.');

            return $response;
        }
        if (parent::insert(array_intersect_key($data, array_flip((array) [
            'user_id',
            'order_detail_id',
            'refund_reason_id',
            'reference',
            'quantity_sent',
            'refund_type',
            'refund_method',
            'shipping_method',
            'payment_status',
            'status',
        ])))) {
            $this->uploadFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);
            $response = ['status' => 'success', 'message' => __('Refund request send successfully.')];
        }

        return $response;
    }

    /**
     * Update Refund
     *
     * @param  array  $request
     * @param  int  $id
     * @return array $data
     */
    public function updateData($request = [], $id = null)
    {
        $data = ['status' => 'fail', 'message' => __('Refund does not found.')];
        $result = parent::where('id', $id);
        if ($result->exists()) {
            try {
                \DB::beginTransaction();

                $result->update(array_intersect_key($request, array_flip((array) ['status'])));

                if ($request['status'] == 'Accepted') {
                    $product = Refund::find($id)->orderDetail->product;
                    if ($product->parent_id) {
                        isset($product->parentDetail()->first()->vendor) ? $product->parentDetail()->first()->vendor->users->first()->user->wallet()->decrementBalance($request['total']) : '';
                    } else {
                        isset($product->vendor) ? $product->vendor->users->first()->user->wallet()->decrementBalance($request['total']) : '';
                    }

                    User::find($request['user_id'])->wallet()->incrementBalance($request['total']);
                    /* inventory refund */
                    $refundDetails = $result->first();

                    if (isset($refundDetails->orderDetail->product) && $refundDetails->orderDetail->is_stock_reduce == 1) {
                        $refundDetails->orderDetail->product->incrementTotalStocks($refundDetails->quantity_sent);
                        $totalRefund = Refund::where('order_detail_id', $refundDetails->orderDetail->id)->where('status', 'Accepted')->sum('quantity_sent');

                        if ($totalRefund == $refundDetails->orderDetail->quantity) {
                            OrderDetail::where('id', $refundDetails->orderDetail->id)->update(['is_stock_reduce' => 0, 'order_status_id' => 7]);
                        }

                    } elseif (isset($refundDetails->orderDetail->product) &&
                        $refundDetails->orderDetail->product->type == 'Variation' &&
                        isset($refundDetails->orderDetail->product->parentDetail) &&
                        $refundDetails->orderDetail->is_stock_reduce == 1) {
                        $refundDetails->orderDetail->product->parentDetail->incrementTotalStocks($refundDetails->quantity_sent);

                        $totalRefund = Refund::where('order_detail_id', $refundDetails->orderDetail->id)->where('status', 'Accepted')->sum('quantity_sent');

                        if ($totalRefund == $refundDetails->orderDetail->quantity) {
                            OrderDetail::where('id', $refundDetails->orderDetail->id)->update(['is_stock_reduce' => 0, 'order_status_id' => 7]);
                        }
                    }
                    /* end inventory */
                    /*transaction*/
                    $vendorTransaction = Transaction::where('reference_number', $result->first()->order_detail_id)->where('transaction_type', 'Vendor_transaction_actual_price')->first();
                    $vendorTransactionWithDiscount = Transaction::where('reference_number', $result->first()->order_detail_id)->where('transaction_type', 'Vendor_transaction_discount_price')->first();
                    $vendorCommission = Transaction::where('reference_number', $result->first()->order_detail_id)->where('transaction_type', 'Vendor_commission')->first();

                    if (! empty($vendorTransaction)) {
                        $discountAmount = ! empty($vendorTransactionWithDiscount) ? $vendorTransactionWithDiscount->discount : 0;
                        $transaction = [];
                        $transaction['user_id'] = Auth::user()->id;
                        $transaction['currency_id'] = $vendorTransaction->currency_id;
                        $transaction['order_id'] = $vendorTransaction->order_id;
                        $transaction['exchange_rate'] = $vendorTransaction->exchange_rate;
                        $transaction['vendor_id'] = $vendorTransaction->vendor_id;
                        $transaction['shop_id'] = $vendorTransaction->shop_id;
                        $transaction['total_amount'] = $vendorTransaction->total_amount - $discountAmount;
                        $transaction['amount'] = $vendorTransaction->amount - $discountAmount;
                        $transaction['reference_number'] = $vendorTransaction->reference_number;
                        $transaction['reference_type'] = 'order_details';
                        $transaction['transaction_type'] = 'Refund_product';
                        $transaction['transaction_date'] = now();
                        $transaction['status'] = 'Accepted';
                        (new Transaction())->store($transaction);
                    }

                    if (! empty($vendorCommission)) {
                        $transaction = [];
                        $transaction['user_id'] = Auth::user()->id;
                        $transaction['currency_id'] = $vendorCommission->currency_id;
                        $transaction['order_id'] = $vendorCommission->order_id;
                        $transaction['exchange_rate'] = $vendorCommission->exchange_rate;
                        $transaction['vendor_id'] = $vendorCommission->vendor_id;
                        $transaction['shop_id'] = $vendorCommission->shop_id;
                        $transaction['total_amount'] = $vendorCommission->total_amount;
                        $transaction['amount'] = $vendorCommission->amount;
                        $transaction['reference_number'] = $vendorCommission->reference_number;
                        $transaction['reference_type'] = 'order_details';
                        $transaction['transaction_type'] = 'Refund_commission';
                        $transaction['transaction_date'] = now();
                        $transaction['status'] = 'Accepted';
                        (new Transaction())->store($transaction);

                        if ($product->parent_id) {
                            isset($product->parentDetail()->first()->vendor) ? $product->parentDetail()->first()->vendor->users->first()->user->wallet()->incrementBalance($vendorCommission->total_amount) : '';
                        } else {
                            isset($product->vendor) ? $product->vendor->users->first()->user->wallet()->incrementBalance($vendorCommission->total_amount) : '';
                        }

                    }
                }
                self::forgetCache();
                $data = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Refund')])];
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                $data['error'] = __('Something went wrong, please try again.');
            }
        }

        return $data;
    }

    /**
     * Find order number that is not refund yet.
     *
     * @return array $orders
     */
    public static function getOrders()
    {
        $details = OrderDetail::select('id', 'order_id', 'quantity')
            ->with('order:id,reference')->where(['is_delivery' => 1])
            ->withSum('refund as refund_quantity', 'quantity_sent')
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->get();

        $orders = [];
        foreach ($details as $detail) {
            if ($detail->refund_quantity == null || $detail->refund_quantity < $detail->quantity) {
                $orders[$detail->order->id] = $detail->order->reference;
            }
        }

        return $orders;
    }

    /**
     * Find items with order reference
     *
     * @param  string  $reference
     * @return array $details
     */
    public static function getProducts($reference)
    {
        $orderDetail = OrderDetail::select('id', 'product_id', 'product_name', 'quantity')
            ->where('is_delivery', 1)
            ->whereHas('order', function ($query) use ($reference) {
                $query->where('reference', $reference);
            })
            ->withSum('refund as refund_quantity', 'quantity_sent')
            ->get();

        $details = [];
        foreach ($orderDetail as $detail) {
            if ($detail->quantity > $detail->refund_quantity) {
                $details[$reference][] = ['id' => $detail->id, 'product_id' => $detail->product_id, 'product_name' => $detail->product_name, 'quantity' => ($detail->quantity - $detail->refund_quantity)];
            }
        }

        return $details;
    }

    /**
     * get reund product image
     *
     * @return mixed
     */
    public function getRefundImage()
    {
        if (! is_null(optional(optional(optional($this->orderDetail)->product)->parent_id))) {
            if (is_array(optional(optional($this->orderDetail)->product)->getImages(true, 'small'))) {
                return optional(optional($this->orderDetail)->product)->getImages(true, 'small')[0];
            } else {
                return optional(optional($this->orderDetail)->product)->getImages(true, 'small');
            }
        }

        return optional(optional($this->orderDetail)->product)->getFeaturedImage('small');
    }

    /**
     * Get Product
     */
    public function getProduct()
    {
        $product = $this->orderDetail?->product()?->first();
        if ($product?->parent_id) {
            $product = $product?->parentDetail()?->first();
        }

        return $product;
    }
}
