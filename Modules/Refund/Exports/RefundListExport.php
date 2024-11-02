<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-02-2022
 */

namespace Modules\Refund\Exports;

use Modules\Refund\Entities\Refund;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class RefundListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from Coupon table]
     */
    public function collection()
    {
        return Refund::getAll();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        $column = [
            'Order Id',
            'Shipping',
            'Refund Reason',
            'Refund Method',
            'Quantity',
            'Amount',
            'Status',
        ];

        return $column;
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $couponList [It has coupons table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($refund): array
    {
        $field = [
            optional(optional($refund->orderDetail)->order)->reference,
            $refund->shipping_method,
            optional($refund->refundReason)->name,
            $refund->refund_method,
            $refund->quantity_sent,
            formatNumber(optional($refund->orderDetail)->price),
            $refund->status,
        ];

        return $field;
    }
}
