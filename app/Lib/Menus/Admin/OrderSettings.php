<?php

/**
 * @author TechVillage <mailto:support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mailto:mostafijur.techvill@gmail.com]>
 *
 * @created 12-10-2023
 */

namespace App\Lib\Menus\Admin;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class OrderSettings
{
    /**
     * Get menu items
     */
    public static function get(): array
    {
        $prms = Permission::getAuthUserPermission(optional(Auth::user())->id);
        $items = [
            [
                'label' => __('Options'),
                'name' => 'option',
                'href' => route('order.setting.option'),
                'position' => '10',
                'visibility' => in_array('App\Http\Controllers\OrderSettingController@index', $prms),
            ],
            [
                'label' => __('Status'),
                'name' => 'status',
                'href' => route('orderStatues.index'),
                'position' => '20',
                'visibility' => in_array('App\Http\Controllers\OrderStatusController@index', $prms),
            ],
            [
                'label' => __('Invoice PDF'),
                'name' => 'invoice',
                'href' => route('invoice.setting.option'),
                'position' => '30',
                'visibility' => in_array('App\Http\Controllers\InvoiceSettingController@index', $prms),
            ],
        ];

        $items = apply_filters('admin_sidebar_configuration_general_settings_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
