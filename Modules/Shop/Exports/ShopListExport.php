<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-09-2021
 */

namespace Modules\Shop\Exports;

use Modules\Shop\Http\Models\Shop;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class ShopListExport implements FromCollection, WithHeadings, WithMapping
{
    public $vendorId = null;

    public function __construct($id = null)
    {
        $this->vendorId = $id;
    }

    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from Shop table and also vendor table through Eloquent Relationship]
     */
    public function collection()
    {
        if ($this->vendorId != null) {
            return Shop::where('vendor_id', $this->vendorId)->get();
        }

        return Shop::getAll();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return [
            'Shop Name',
            'Vendor',
            'Email',
            'Website',
            'Phone',
            'Status',
            'Created',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $shopList [It has shops table info and vendors table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($shopList): array
    {
        return [
            ucfirst($shopList->name),
            isset($shopList->vendor->name) ? $shopList->vendor->name : '',
            isset($shopList->email) ? $shopList->email : '',
            isset($shopList->website) ? $shopList->website : '',
            isset($shopList->phone) ? $shopList->phone : '',
            ucfirst($shopList->status),
            timeZoneFormatDate($shopList->created_at),
        ];
    }
}
