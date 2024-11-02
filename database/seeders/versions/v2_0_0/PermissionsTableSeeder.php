<?php

namespace Database\Seeders\versions\v2_0_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\DashboardController@setWidgetData')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\DashboardController@setWidgetData',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\DashboardController',
                'controller_name' => 'DashboardController',
                'method_name' => 'setWidgetData',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\DashboardController@setWidgetOption')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\DashboardController@setWidgetOption',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\DashboardController',
                'controller_name' => 'DashboardController',
                'method_name' => 'setWidgetOption',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\DashboardController@forgetWidget')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\DashboardController@forgetWidget',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\DashboardController',
                'controller_name' => 'DashboardController',
                'method_name' => 'forgetWidget',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@index')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@index',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController',
                'controller_name' => 'HomeController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@create')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@create',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController',
                'controller_name' => 'HomeController',
                'method_name' => 'create',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@store')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@store',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController',
                'controller_name' => 'HomeController',
                'method_name' => 'store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@edit')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@edit',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController',
                'controller_name' => 'HomeController',
                'method_name' => 'edit',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@update')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@update',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController',
                'controller_name' => 'HomeController',
                'method_name' => 'update',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@delete')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController@delete',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\HomeController',
                'controller_name' => 'HomeController',
                'method_name' => 'delete',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@edit')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@edit',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'edit',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@editElement')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@editElement',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'editElement',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@editElement')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@editElement',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'editElement',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@updateComponent')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@updateComponent',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'updateComponent',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@deleteComponent')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@deleteComponent',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'deleteComponent',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@updateAllComponents')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@updateAllComponents',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'updateAllComponents',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@ajaxResourceFetch')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@ajaxResourceFetch',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'ajaxResourceFetch',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@getComponentProduct')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController@getComponentProduct',
                'controller_path' => 'Modules\\CMS\\Http\\Controllers\\Vendor\\BuilderController',
                'controller_name' => 'BuilderController',
                'method_name' => 'getComponentProduct',
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

        if (! Permission::where('name', 'App\\Http\\Controllers\\InvoiceSettingController@index')->first()) {

            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\InvoiceSettingController@index',
                'controller_path' => 'App\\Http\\Controllers\\InvoiceSettingController',
                'controller_name' => 'InvoiceSettingController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\BarcodeController@product')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\BarcodeController@product',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\BarcodeController',
                'controller_name' => 'BarcodeController',
                'method_name' => 'product',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\BarcodeController@search')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\BarcodeController@search',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\BarcodeController',
                'controller_name' => 'BarcodeController',
                'method_name' => 'search',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\InvoiceSettingController@index')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\InvoiceSettingController@index',
                'controller_path' => 'App\\Http\\Controllers\\InvoiceSettingController',
                'controller_name' => 'InvoiceSettingController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }
        
        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@index')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@index',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@getData')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@getData',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'getData',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@store')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@store',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@edit')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@edit',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'edit',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@update')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@update',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'update',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@destroy')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@destroy',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'destroy',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@getParentData')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@getParentData',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'getParentData',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@moveNode')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@moveNode',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'moveNode',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@suggestion')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@suggestion',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'suggestion',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        if (! Permission::where('name', 'App\\Http\\Controllers\\Vendor\\CategoryController@assignCategory')->first()) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Vendor\\CategoryController@assignCategory',
                'controller_path' => 'App\\Http\\Controllers\\Vendor\\CategoryController',
                'controller_name' => 'CategoryController',
                'method_name' => 'assignCategory',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }
    }
}
