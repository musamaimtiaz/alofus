<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 21-11-2021
 */

namespace Modules\Newsletter\Exports;

use Modules\Newsletter\Entities\Subscriber;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class SubscriberListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from Coupon table]
     */
    public function collection()
    {
        return Subscriber::getAll();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        $column = [
            'Email',
            'Status',
            'Confirmation Date',
        ];

        return $column;
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $subscriber [It has subscribers table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($subscriber): array
    {
        $field = [
            $subscriber->email,
            $subscriber->status,
            $subscriber->confirmation_date,
        ];

        return $field;
    }
}
