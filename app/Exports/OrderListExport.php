<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 20-01-2022
 */

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class OrderListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return Order::all();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return [
            'Order',
            'Customer',
            'Vendor',
            'Amount',
            'Order Status',
            'Payment Status',
            'Created',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $userList [It has users table info and roles table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($orderList): array
    {
        return [
            $orderList->reference,
            optional($orderList->user)->name,
            $orderList->vendorName($orderList->id),
            formatNumber($orderList->total),
            optional($orderList->orderStatus)->name,
            $orderList->paymentStatus($orderList->total, $orderList->paid),
            formatDate($orderList->created_at) . ' ' . timeZoneGetTime($orderList->created_at),
        ];
    }
}
