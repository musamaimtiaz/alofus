<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class VendorOrderListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        $vendorId = session()->get('vendorId');
        $orders = Order::whereHas('orderDetails', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        })->with('orderDetails')->get();

        return $orders;
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return [
            'Invoice',
            'Customer',
            'Number of Products',
            'Total Amount',
            'Status',
            'Payment Status',
            'Created At',
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
            formatCurrencyAmount($orderList->getTotalVendorProduct(session()->get('vendorId'), $orderList->id)),
            formatCurrencyAmount($orderList->vendorProductPrice(session()->get('vendorId'), $orderList->id)),
            $orderList->status,
            $orderList->paymentStatus($orderList->total, $orderList->paid),
            formatDate($orderList->created_at) . ' ' . timeZoneGetTime($orderList->created_at),
        ];
    }
}
