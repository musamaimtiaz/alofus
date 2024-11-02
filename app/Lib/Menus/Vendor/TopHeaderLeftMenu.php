<?php

/**
 * @author TechVillage <mailto:support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mailto:mostafijur.techvill@gmail.com]>
 *
 * @created 12-10-2023
 */

namespace App\Lib\Menus\Vendor;

class TopHeaderLeftMenu
{
    /**
     * Get menu items
     */
    public static function get(): array
    {
        $user = auth()->user();
        $items = [
            'full-screen' => [
                'item' => '<a href="javascript:" class="full-screen text-decoration-none ltr:ps-2 rtl:pe-2" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a>',
                'position' => '10',
                'visibility' => true,
            ],
            'visit_site' => [
                'item' => '<a class="d-flex align-items-center text-decoration-none" href="' . route('site.index') . '" target="_blank">
                <i class="feather icon-globe"></i><span class="list-curent-color ltr:ms-2 rtl:me-2">' . __('Visit Site') . '</span></a>',
                'position' => '20',
                'visibility' => true,
            ],
            'customer_panel' => [
                'item' => '<a class="d-flex align-items-center text-decoration-none" href="' . route('site.dashboard') . '" target="_blank">
                <i class="feather icon-external-link"></i><span class="ltr:ms-2 rtl:me-2 list-curent-color">' . __('Customer Panel') . '</span></a>',
                'position' => '30',
                'visibility' => true,
            ],
            'admin_panel' => [
                'item' => '<a class="d-flex align-items-center text-decoration-none" href="' . route('dashboard') . '" target="_blank">
                <i class="feather icon-external-link"></i><span class="ltr:ms-2 rtl:me-2 list-curent-color">' . __('Admin Panel') . '</span></a>',
                'position' => '40',
                'visibility' => ($user->role()->slug == 'super-admin'),
            ],
            'shop' => [
                'item' => '<a class="d-flex align-items-center text-decoration-none" href="' . route('site.shop', ['alias' => $user->shop()->alias]) . '" target="_blank">
                <i class="feather icon-external-link"></i><span class="ltr:ms-2 rtl:me-2 list-curent-color">' . __('Shop') . '</span></a>',
                'position' => '40',
                'visibility' => ! empty($user->shop()) && isset($user->shop()->alias) && ($user->roles()->first()->slug == 'vendor-admin' || $user->roles()->first()->slug == 'super-admin'),
            ],
        ];

        $items = apply_filters('vendor_top_header_left_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
