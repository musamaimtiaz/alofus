<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 21-11-2021
 */

namespace Modules\Coupon\Exports;

use Modules\Coupon\Http\Models\Coupon;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class CouponListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from Coupon table]
     */
    public function collection()
    {
        return Coupon::getAll();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        $column = [
            'Name',
            'Code',
            'Discount Type',
            'Discount Amount',
            'Start Date',
            'End Date',
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
    public function map($couponList): array
    {
        $field = [
            $couponList->name,
            $couponList->code,
            $couponList->discount_type,
            formatCurrencyAmount($couponList->discount_amount),
            $couponList->start_date,
            $couponList->end_date,
            $couponList->status,
        ];

        return $field;
    }
}
