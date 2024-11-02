<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 17-08-2021
 *
 * @modified 29-09-2021
 */

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class VendorListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from Vendor table through Eloquent Relationship]
     */
    public function collection()
    {
        return Vendor::getAll();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Formal Name',
            'Website',
            'Status',
            'Created At',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $vendorList [It has vendors table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($vendorList): array
    {
        return [
            $vendorList->name,
            $vendorList->email,
            $vendorList->phone,
            $vendorList->formal_name,
            $vendorList->website,
            $vendorList->status,
            formatDate($vendorList->created_at) . ' ' . timeZoneGetTime($vendorList->created_at),
        ];
    }
}
