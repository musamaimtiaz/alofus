<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 14-12-2021
 *
 * @modified 15-02-2022
 */

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Facades\Validator;

class Transaction extends Model
{
    use ModelTrait;

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
     * Relation with Currency model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Relation with Shop model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Modules\Shop\Http\Models\Shop::class);
    }

    /**
     * Relation with Vendor model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Relation with Order model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relation with PaymentMethod model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function withdrawalMethod()
    {
        return $this->belongsTo(WithdrawalMethod::class);
    }

    /**
     * Update validation
     *
     * @param  array  $data
     * @param  int  $id
     * @return mixed
     */
    protected static function updateValidation($data = [])
    {
        $validator = Validator::make($data, [
            'status' => 'required|in:Pending,Accepted,Rejected',
        ]);

        return $validator;
    }

    /**
     * Wallet Validation
     *
     * @param  array  $data
     * @return mixed
     */
    protected static function withdrawValidation($data = [])
    {
        $validator = Validator::make($data, [
            'withdrawal_method_id' => 'required|exists:withdrawal_methods,id',
            'currency_id' => 'required|exists:currencies,id',
            'amount' => 'required|numeric|min:1',
        ]);

        return $validator;
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return int|null
     */
    public function orderTransactionStore($data = [])
    {
        if (parent::insert($data)) {
            return true;
        }

        return false;
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
     * Store Data
     *
     * @param  array  $data
     * @return array $response
     */
    public function storeData($data = [])
    {
        $data['user_id'] = auth()->user()->id;
        $data['transaction_date'] = now();
        $withdrawal = false;

        if ($data['transaction_type'] == 'Withdrawal') {
            $walletBalance = auth()->user()->wallet($data['currency_id'])->balance;
            if ($walletBalance < $data['amount']) {
                return ['status' => 'fail', 'message' => __('Your wallet balance is low.')];
            }
            $withdrawal = true;
        }

        if (parent::insert($data)) {
            if ($withdrawal) {
                auth()->user()->wallet($data['currency_id'])->decrementBalance($data['amount']);
            }
            self::forgetCache();

            return ['status' => 'success', 'message' => __('Withdrawal request send successfully.')];
        }

        return ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
    }

    /**
     * Update Data
     *
     * @param  array  $data
     * @return array $response
     */
    public function updateData($data, $id)
    {
        $data['transaction_date'] = now();
        $transaction = parent::where('id', $id);
        if ($transaction->update($data)) {
            $transaction = $transaction->first();
            if ($transaction['transaction_type'] == 'Withdrawal' && $data['status'] == 'Rejected') {
                $user = User::getAll()->where('id', $transaction->user_id)->first();
                $user->wallet($transaction['currency_id'])->incrementBalance($transaction['amount']);
            }
            self::forgetCache();

            return ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Transaction')])];
        }

        return ['status' => 'fail', 'message' => __('Something went wrong, please try again.')];
    }
}
