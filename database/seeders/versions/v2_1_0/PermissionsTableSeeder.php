<?php

namespace Database\Seeders\versions\v2_1_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\SmsConfigurationController@index')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SmsConfigurationController@index',
                'controller_path' => 'App\\Http\\Controllers\\SmsConfigurationController',
                'controller_name' => 'SmsConfigurationController',
                'method_name' => 'index',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\SmsConfigurationController@update')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SmsConfigurationController@update',
                'controller_path' => 'App\\Http\\Controllers\\SmsConfigurationController',
                'controller_name' => 'SmsConfigurationController',
                'method_name' => 'update',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\SmsTemplateController@index')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SmsTemplateController@index',
                'controller_path' => 'App\\Http\\Controllers\\SmsTemplateController',
                'controller_name' => 'SmsTemplateController',
                'method_name' => 'index',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\SmsTemplateController@edit')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SmsTemplateController@edit',
                'controller_path' => 'App\\Http\\Controllers\\SmsTemplateController',
                'controller_name' => 'SmsTemplateController',
                'method_name' => 'edit',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\SmsTemplateController@update')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SmsTemplateController@update',
                'controller_path' => 'App\\Http\\Controllers\\SmsTemplateController',
                'controller_name' => 'SmsTemplateController',
                'method_name' => 'update',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\SmsTemplateController@destroy')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\SmsTemplateController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\SmsTemplateController',
                'controller_name' => 'SmsTemplateController',
                'method_name' => 'destroy',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@index')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@index',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'index',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@destroy')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'destroy',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@markAsRead')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@markAsRead',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsRead',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@markAsUnread')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@markAsUnread',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsUnread',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@markAsReadAll')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@markAsReadAll',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsReadAll',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\NotificationController@index')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\NotificationController@index',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\NotificationController@destroy')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\NotificationController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'destroy',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\NotificationController@markAsRead')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\NotificationController@markAsRead',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsRead',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\NotificationController@markAsUnread')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\NotificationController@markAsUnread',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsUnread',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\NotificationController@markAsReadAll')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\NotificationController@markAsReadAll',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsReadAll',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\NotificationController@headerNotification')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\NotificationController@headerNotification',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'headerNotification',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Site\\NotificationController@index')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Site\\NotificationController@index',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ], [
                    'permission_id' => $permissionId,
                    'role_id' => 3,
                ],
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Site\\NotificationController@destroy')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Site\\NotificationController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'destroy',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ], [
                    'permission_id' => $permissionId,
                    'role_id' => 3,
                ],
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Site\\NotificationController@markAsRead')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Site\\NotificationController@markAsRead',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsRead',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ], [
                    'permission_id' => $permissionId,
                    'role_id' => 3,
                ],
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Site\\NotificationController@markAsUnread')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Site\\NotificationController@markAsUnread',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsUnread',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ], [
                    'permission_id' => $permissionId,
                    'role_id' => 3,
                ],
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Site\\NotificationController@markAsReadAll')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Site\\NotificationController@markAsReadAll',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'markAsReadAll',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ], [
                    'permission_id' => $permissionId,
                    'role_id' => 3,
                ],
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@view')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\NotificationController@view',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'view',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Site\\NotificationController@view')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Site\\NotificationController@view',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'view',
            ]);

            PermissionRole::insert([
                [
                    'permission_id' => $permissionId,
                    'role_id' => 2,
                ], [
                    'permission_id' => $permissionId,
                    'role_id' => 3,
                ],
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@setting')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\NotificationController@setting',
                'controller_path' => 'App\\Http\\Controllers\\Site\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'setting',
            ]);
        }
        
        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@log')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@log',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'log',
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\NotificationController@destroyLog')->first()) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\NotificationController@destroyLog',
                'controller_path' => 'App\\Http\\Controllers\\NotificationController',
                'controller_name' => 'NotificationController',
                'method_name' => 'destroyLog',
            ]);
        }
    }
}
