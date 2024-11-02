<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    use ModelTrait;

    public $timestamps = false;

    protected $fillable = ['currency_id'];

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
     * Store user wallet information
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            return true;
        }

        return false;
    }

    /**
     * Increase user wallet balance
     *
     * @param  float  $amount
     * @return void
     */
    public function incrementBalance($amount = 0)
    {
        $this->increment('balance', $amount);
    }

    /**
     * Decrease user wallet balance
     *
     * @param  float  $amount
     * @return void
     */
    public function decrementBalance($amount = 0)
    {
        $this->decrement('balance', $amount);
    }

    /**
     * @return mixed
     */
    public function vendorCommission($currencyId = null)
    {
        if (is_null($currencyId)) {
            $currencyId = preference('dflt_currency_id');
        }

        $commission = Transaction::where('vendor_id', session()->get('vendorId'))
            ->where('transaction_type', 'Commission')
            ->where('currency_id', $currencyId)
            ->where('status', 'Accepted')
            ->sum('total_amount');
        $refund = Transaction::where('vendor_id', session()->get('vendorId'))
            ->where('transaction_type', 'Refund Commission')
            ->where('currency_id', $currencyId)
            ->where('status', 'Accepted')
            ->sum('total_amount');

        return $commission - $refund;
    }
}
