<?php
/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 14-05-2022
 */

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class VendorTransactionListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return Transaction::select('transactions.id', 'user_id', 'currency_id', 'transactions.status', 'withdrawal_method_id', 'amount', 'charge_amount', 'commission_amount', 'discount_amount', 'total_amount', 'transaction_type', 'order_id', 'transaction_date')->where('vendor_id', session()->get('vendorId'))->with(['user:id,name', 'currency:id,name', 'withdrawalMethod:id,method_name', 'order'])->get();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return [
            'User',
            'Currency',
            'Method',
            'Amount',
            'Fee',
            'Total',
            'Type',
            'Status',
            'Date',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $WithdrawalHistory [It has transaction table info and currency table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($transaction): array
    {
        $method = '';
        if (($transaction->transaction_type == 'Withdrawal')) {
            $method = optional($transaction->withdrawalMethod)->method_name;
        } elseif ($transaction->transaction_type == 'Order') {
            $method = optional(optional($transaction->order)->paymentMethod)->gateway;
        }

        return [
            optional($transaction->user)->name,
            optional($transaction->currency)->name,
            $method,
            formatCurrencyAmount($transaction->amount),
            formatCurrencyAmount($transaction->charge_amount + $transaction->commission_amount + $transaction->discount_amount),
            formatCurrencyAmount($transaction->total_amount),
            $transaction->transaction_type,
            $transaction->status,
            formatDate($transaction->transaction_date),
        ];
    }
}
