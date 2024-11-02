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

class VendorWithdrawalHistoryExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return Transaction::where(['user_id' => auth()->user()->id, 'transaction_type' => 'Withdrawal'])->get();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return [
            'Currency',
            'Method',
            'Amount',
            'Fee',
            'Total',
            'Type',
            'Date',
            'Updated At',
            'Status',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $WithdrawalHistory [It has transaction table info and currency table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($withdrawal): array
    {
        return [
            optional($withdrawal->currency)->name,
            optional($withdrawal->withdrawalMethod)->method_name,
            formatCurrencyAmount($withdrawal->amount),
            formatCurrencyAmount($withdrawal->charge_amount + $withdrawal->commission_amount + $withdrawal->discount_amount),
            formatCurrencyAmount($withdrawal->total_amount),
            $withdrawal->transaction_type,
            timeZoneFormatDate($withdrawal->transaction_date),
            ! empty($withdrawal->updated_at) ? timeZoneFormatDate($withdrawal->updated_at) . timeZoneGetTime($withdrawal->updated_at) : '',
            $withdrawal->status,
        ];
    }
}
