<?php

namespace Database\Seeders\versions\v1_4_0;

use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $dbPermission = Permission::where([
            'name' => '\\App\\Http\\Controllers\\Api\\AuthController@resendUserVerificationCode',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => '\\App\\Http\\Controllers\\Api\\AuthController@resendUserVerificationCode',
                'controller_path' => '\\App\\Http\\Controllers\\Api\\AuthController',
                'controller_name' => 'AuthController',
                'method_name' => 'resendUserVerificationCode',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\ProductController@getShipping',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\ProductController@getShipping',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\ProductController',
                'controller_name' => 'ProductController',
                'method_name' => 'getShipping',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\UserController@addonActivity',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\UserController@addonActivity',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\UserController',
                'controller_name' => 'UserController',
                'method_name' => 'addonActivity',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController@signUp',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController@signUp',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController',
                'controller_name' => 'RegisteredSellerController',
                'method_name' => 'signUp',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController@resendVerificationCode',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController@resendVerificationCode',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController',
                'controller_name' => 'RegisteredSellerController',
                'method_name' => 'resendVerificationCode',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController@otpVerification',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController@otpVerification',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\RegisteredSellerController',
                'controller_name' => 'RegisteredSellerController',
                'method_name' => 'otpVerification',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\SellerController@index',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\SellerController@index',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\SellerController',
                'controller_name' => 'SellerController',
                'method_name' => 'index',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\SellerController@vendorProfile',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Api\\User\\SellerController@vendorProfile',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\SellerController',
                'controller_name' => 'SellerController',
                'method_name' => 'vendorProfile',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\ExportController@index',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ExportController@index',
                'controller_path' => 'App\\Http\\Controllers\\ExportController',
                'controller_name' => 'ExportController',
                'method_name' => 'index',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\ExportController@productExport',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\ExportController@productExport',
                'controller_path' => 'App\\Http\\Controllers\\ExportController',
                'controller_name' => 'ExportController',
                'method_name' => 'productExport',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Site\\SiteController@allCategories',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Site\\SiteController@allCategories',
                'controller_path' => 'App\\Http\\Controllers\\Site\\SiteController',
                'controller_name' => 'SiteController',
                'method_name' => 'allCategories',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Site\\ResetDataController@reset',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'App\\Http\\Controllers\\Site\\ResetDataController@reset',
                'controller_path' => 'App\\Http\\Controllers\\Site\\ResetDataController',
                'controller_name' => 'ResetDataController',
                'method_name' => 'reset',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\AuthorizeNet\\Http\\Controllers\\AuthorizeNetController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\AuthorizeNet\\Http\\Controllers\\AuthorizeNetController@store',
                'controller_path' => 'Modules\\AuthorizeNet\\Http\\Controllers\\AuthorizeNetController',
                'controller_name' => 'AuthorizeNetController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\AuthorizeNet\\Http\\Controllers\\AuthorizeNetController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\AuthorizeNet\\Http\\Controllers\\AuthorizeNetController@edit',
                'controller_path' => 'Modules\\AuthorizeNet\\Http\\Controllers\\AuthorizeNetController',
                'controller_name' => 'AuthorizeNetController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\CheckPayments\\Http\\Controllers\\CheckPaymentsController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\CheckPayments\\Http\\Controllers\\CheckPaymentsController@store',
                'controller_path' => 'Modules\\CheckPayments\\Http\\Controllers\\CheckPaymentsController',
                'controller_name' => 'CheckPaymentsController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\CheckPayments\\Http\\Controllers\\CheckPaymentsController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\CheckPayments\\Http\\Controllers\\CheckPaymentsController@edit',
                'controller_path' => 'Modules\\CheckPayments\\Http\\Controllers\\CheckPaymentsController',
                'controller_name' => 'CheckPaymentsController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DirectBankTransfer\\Http\\Controllers\\DirectBankTransferController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\DirectBankTransfer\\Http\\Controllers\\DirectBankTransferController@store',
                'controller_path' => 'Modules\\DirectBankTransfer\\Http\\Controllers\\DirectBankTransferController',
                'controller_name' => 'DirectBankTransferController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DirectBankTransfer\\Http\\Controllers\\DirectBankTransferController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\DirectBankTransfer\\Http\\Controllers\\DirectBankTransferController@edit',
                'controller_path' => 'Modules\\DirectBankTransfer\\Http\\Controllers\\DirectBankTransferController',
                'controller_name' => 'DirectBankTransferController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\MediaManager\\Http\\Controllers\\MediaManagerController@storeExtension',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\MediaManager\\Http\\Controllers\\MediaManagerController@storeExtension',
                'controller_path' => 'Modules\\MediaManager\\Http\\Controllers\\MediaManagerController',
                'controller_name' => 'MediaManagerController',
                'method_name' => 'storeExtension',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\MediaManager\\Http\\Controllers\\MediaManagerController@getExtensionAjaxQuery',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\MediaManager\\Http\\Controllers\\MediaManagerController@getExtensionAjaxQuery',
                'controller_path' => 'Modules\\MediaManager\\Http\\Controllers\\MediaManagerController',
                'controller_name' => 'MediaManagerController',
                'method_name' => 'getExtensionAjaxQuery',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\MtnMomo\\Http\\Controllers\\MtnMomoController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\MtnMomo\\Http\\Controllers\\MtnMomoController@store',
                'controller_path' => 'Modules\\MtnMomo\\Http\\Controllers\\MtnMomoController',
                'controller_name' => 'MtnMomoController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\MtnMomo\\Http\\Controllers\\MtnMomoController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\MtnMomo\\Http\\Controllers\\MtnMomoController@edit',
                'controller_path' => 'Modules\\MtnMomo\\Http\\Controllers\\MtnMomoController',
                'controller_name' => 'MtnMomoController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\NGenius\\Http\\Controllers\\NGeniusController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\NGenius\\Http\\Controllers\\NGeniusController@store',
                'controller_path' => 'Modules\\NGenius\\Http\\Controllers\\NGeniusController',
                'controller_name' => 'NGeniusController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\NGenius\\Http\\Controllers\\NGeniusController@viewAddon',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\NGenius\\Http\\Controllers\\NGeniusController@viewAddon',
                'controller_path' => 'Modules\\NGenius\\Http\\Controllers\\NGeniusController',
                'controller_name' => 'NGeniusController',
                'method_name' => 'viewAddon',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Paytm\\Http\\Controllers\\PaytmController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Paytm\\Http\\Controllers\\PaytmController@store',
                'controller_path' => 'Modules\\Paytm\\Http\\Controllers\\PaytmController',
                'controller_name' => 'PaytmController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Paytm\\Http\\Controllers\\PaytmController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Paytm\\Http\\Controllers\\PaytmController@edit',
                'controller_path' => 'Modules\\Paytm\\Http\\Controllers\\PaytmController',
                'controller_name' => 'PaytmController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Paytr\\Http\\Controllers\\PaytrController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Paytr\\Http\\Controllers\\PaytrController@store',
                'controller_path' => 'Modules\\Paytr\\Http\\Controllers\\PaytrController',
                'controller_name' => 'PaytrController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Paytr\\Http\\Controllers\\PaytrController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Paytr\\Http\\Controllers\\PaytrController@edit',
                'controller_path' => 'Modules\\Paytr\\Http\\Controllers\\PaytrController',
                'controller_name' => 'PaytrController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@index',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@index',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'index',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@create',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@create',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'create',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@store',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@show',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@show',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'show',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@edit',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@update',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@update',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'update',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@destroy',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@destroy',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'destroy',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@getTemplate',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageController@getTemplate',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageController',
                'controller_name' => 'PackageController',
                'method_name' => 'getTemplate',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@index',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@index',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'index',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@create',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@create',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'create',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@store',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@show',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@show',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'show',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@edit',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@update',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@update',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'update',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@destroy',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@destroy',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'destroy',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@setting',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@setting',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'setting',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@payment',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@payment',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'payment',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoice',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'invoice',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoicePdf',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoicePdf',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'invoicePdf',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoiceEmail',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController@invoiceEmail',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\PackageSubscriptionController',
                'controller_name' => 'PackageSubscriptionController',
                'method_name' => 'invoiceEmail',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Upgrader\\Http\\Controllers\\SystemUpdateController@upgrade',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\Upgrader\\Http\\Controllers\\SystemUpdateController@upgrade',
                'controller_path' => 'Modules\\Upgrader\\Http\\Controllers\\SystemUpdateController',
                'controller_name' => 'SystemUpdateController',
                'method_name' => 'upgrade',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\VoguePay\\Http\\Controllers\\VoguePayController@store',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\VoguePay\\Http\\Controllers\\VoguePayController@store',
                'controller_path' => 'Modules\\VoguePay\\Http\\Controllers\\VoguePayController',
                'controller_name' => 'VoguePayController',
                'method_name' => 'store',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\VoguePay\\Http\\Controllers\\VoguePayController@edit',
        ])->first();

        if (! $dbPermission) {
            Permission::insert([
                'name' => 'Modules\\VoguePay\\Http\\Controllers\\VoguePayController@edit',
                'controller_path' => 'Modules\\VoguePay\\Http\\Controllers\\VoguePayController',
                'controller_name' => 'VoguePayController',
                'method_name' => 'edit',
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@index',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@index',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'index',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@store',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@store',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@paid',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@paid',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'paid',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@history',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@history',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'history',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@invoice',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@invoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'invoice',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@pdfInvoice',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@pdfInvoice',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'pdfInvoice',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@cancel',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController@cancel',
                'controller_path' => 'Modules\\Subscription\\Http\\Controllers\\Vendor\\SubscriptionController',
                'controller_name' => 'SubscriptionController',
                'method_name' => 'cancel',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@automatedDatabaseBackupForm',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'automatedDatabaseBackupForm',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@automatedDatabaseBackupForm',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@store',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'store',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@manualDatabaseBackupForm',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'manualDatabaseBackupForm',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@manualDatabaseBackupForm',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@manualDatabaseBackup',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'manualDatabaseBackup',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@manualDatabaseBackup',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@list',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'list',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@list',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@download',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'download',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@download',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@destroy',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DatabaseBackupController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController',
                'method_name' => 'destroy',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DatabaseBackupController@destroy',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DropboxSettingController@create',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DropboxSettingController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DropboxSettingController',
                'method_name' => 'create',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DropboxSettingController@create',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DropboxSettingController@store',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'DropboxSettingController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DropboxSettingController',
                'method_name' => 'store',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\DropboxSettingController@store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\GoogleDriveSettingController@create',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'GoogleDriveSettingController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\GoogleDriveSettingController',
                'method_name' => 'create',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\GoogleDriveSettingController@create',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\GoogleDriveSettingController@store',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'controller_name' => 'GoogleDriveSettingController',
                'controller_path' => 'Modules\\DatabaseBackup\\Http\\Controllers\\GoogleDriveSettingController',
                'method_name' => 'store',
                'name' => 'Modules\\DatabaseBackup\\Http\\Controllers\\GoogleDriveSettingController@store',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 1,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@getConversations',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@getConversations',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'getConversations',
            ]);
            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@sendProductDetails',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@sendProductDetails',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'sendProductDetails',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@initiateChatWithVendor',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@initiateChatWithVendor',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'initiateChatWithVendor',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@contact-list',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@contact-list',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'contact-list',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@storeMessage',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@storeMessage',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'storeMessage',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@createChat',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@createChat',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'createChat',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@inboxRefresh',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController@inboxRefresh',
                'controller_path' => 'Modules\\Ticket\\Http\\Controllers\\Api\\User\\ChatController',
                'controller_name' => 'ChatController',
                'method_name' => 'inboxRefresh',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }

        $dbPermission = Permission::where([
            'name' => 'App\\Http\\Controllers\\Api\\User\\UserController@removeImage',
        ])->first();

        if (! $dbPermission) {
            $permissionId = Permission::insertGetId([
                'name' => 'App\\Http\\Controllers\\Api\\User\\UserController@removeImage',
                'controller_path' => 'App\\Http\\Controllers\\Api\\User\\UserController',
                'controller_name' => 'UserController',
                'method_name' => 'removeImage',
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 2,
            ]);

            PermissionRole::insert([
                'permission_id' => $permissionId,
                'role_id' => 3,
            ]);
        }
    }
}
