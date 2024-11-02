<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 22-02-2022
 */

namespace App\Exports;

use App\Models\{Transaction};
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class TransactionListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return Transaction::getAll();
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
        return [
            optional($transaction->user)->name,
            optional($transaction->currency)->name,
            optional($transaction->withdrawalMethod)->method_name,
            formatCurrencyAmount($transaction->amount),
            formatCurrencyAmount($transaction->charge_amount + $transaction->commission_amount + $transaction->discount_amount),
            formatCurrencyAmount($transaction->total_amount),
            $transaction->transaction_type,
            $transaction->status,
        ];
    }
}
