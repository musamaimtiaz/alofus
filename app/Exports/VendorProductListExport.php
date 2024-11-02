<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-12-2021
 */

namespace App\Exports;

use App\Models\{
    Product
};
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class VendorProductListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return Product::select('id', 'name', 'code', 'sku', 'price', 'status', 'vendor_id', 'brand_id')->where('status', 'Active')->where('vendor_id', session()->get('vendorId'))->with(['vendor:id,name', 'brand:id,name', 'productCategory'])->get();
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
            'Category',
            'Brand',
            'Vendor',
            'Product Code',
            'SKU',
            'Price',
            'Created At',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $userList [It has users table info and roles table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($products): array
    {
        return [
            $products->name,
            optional($products->productCategory->category)->name,
            optional($products->brand)->name,
            optional($products->vendor)->name,
            $products->code,
            $products->sku,
            $products->price,
            timeZoneFormatDate($products->created_at),
        ];
    }
}
