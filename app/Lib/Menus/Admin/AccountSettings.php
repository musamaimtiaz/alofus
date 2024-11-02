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

class AccountSettings
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
                'name' => 'options',
                'href' => route('account.setting.option'),
                'position' => '10',
                'visibility' => in_array('App\Http\Controllers\AccountSettingController@index', $prms),
            ],
            [
                'label' => __('Single Sign On :x', ['x' => '(SSO)']),
                'name' => 'sso',
                'href' => route('sso.index'),
                'position' => '20',
                'visibility' => in_array('App\Http\Controllers\SsoController@index', $prms),
            ],
            [
                'label' => __('User Verifications'),
                'name' => 'email_verify_setting',
                'href' => route('emailVerifySetting'),
                'position' => '30',
                'visibility' => in_array('App\Http\Controllers\EmailController@emailVerifySetting', $prms),
            ],
            [
                'label' => __('Password Strength'),
                'name' => 'password_preference',
                'href' => route('preferences.password'),
                'position' => '40',
                'visibility' => in_array('App\Http\Controllers\PreferenceController@password', $prms),
            ],
            [
                'label' => __('Roles'),
                'name' => 'role',
                'href' => route('roles.index'),
                'position' => '50',
                'visibility' => in_array('App\Http\Controllers\RoleController@index', $prms),
            ],
            [
                'label' => __('Permissions'),
                'name' => 'permission',
                'href' => route('permissionRoles.index'),
                'position' => '60',
                'visibility' => in_array('App\Http\Controllers\PermissionRoleController@index', $prms),
            ],
            [
                'label' => __('Notifications'),
                'name' => 'notification',
                'href' => route('notifications.setting'),
                'position' => '60',
                'visibility' => in_array('App\Http\Controllers\NotificationController@setting', $prms),
            ],
        ];

        $items = apply_filters('admin_sidebar_configuration_account_settings_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
