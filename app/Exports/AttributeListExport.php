<?php

namespace App\Exports;

use App\Models\Attribute;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class AttributeListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return Attribute::getAll();
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
            'Attribute Group',
            'Is Filterable',
            'Status',
            'Created At',
        ];
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $userList [It has users table info and roles table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($attributes): array
    {
        return [
            $attributes->name,
            optional($attributes->attributeGroup)->name,
            $attributes->is_filterable == '1' ? __('Yes') : __('No'),
            $attributes->status,
            formatDate($attributes->created_at) . ' ' . timeZoneGetTime($attributes->created_at),
        ];
    }
}
