<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-05-2021
 *
 * @modified 06-09-2021
 */

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@showLoginForm');
Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/authenticate', 'LoginController@authenticate')->name('login.post');

// Password reset
Route::get('password/resets/{token}', 'LoginController@showResetForm')->name('password.reset');
Route::post('password/resets', 'LoginController@setPassword')->name('password.resets');
Route::post('password/email', 'LoginController@sendResetLinkEmail')->name('login.sendResetLink');
Route::get('password/reset', 'LoginController@reset')->name('login.reset');
Route::get('password/reset-otp', 'LoginController@resetOtp')->name('reset.otp');

Route::get('/impersonate/{impersonate}', 'LoginController@impersonate')->name('impersonator');

Route::get('/cancel-impersonate', 'LoginController@cancelImpersonate')->name('impersonator-cancel');

Route::get('/logout', 'LoginController@logout')->name('users.logout');

Route::group(['middleware' => ['auth', 'locale', 'permission']], function () {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        \Session::flash('success', __('Cache successfully cleared.'));

        return back();
    })->name('clear-cache');

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('dashboard/widget', 'DashboardController@setWidgetData');
    Route::post('dashboard/widget/option', 'DashboardController@setWidgetOption');
    Route::get('dashboard/widget/forget-cache', 'DashboardController@forgetWidget')->name('dashboard.forget_widget');

    // Role
    Route::get('role/list', 'RoleController@index')->name('roles.index');
    Route::get('role/create', 'RoleController@create')->name('roles.create');
    Route::post('role/store', 'RoleController@store')->middleware(['checkForDemoMode'])->name('roles.store');
    Route::get('role/edit/{id}', 'RoleController@edit')->name('roles.edit');
    Route::post('role/update/{id}', 'RoleController@update')->middleware(['checkForDemoMode'])->name('roles.update');
    Route::post('role/delete/{id}', 'RoleController@destroy')->middleware(['checkForDemoMode'])->name('roles.destroy');

    // Role
    Route::get('permission-role', 'PermissionRoleController@index')->name('permissionRoles.index');
    Route::get('generate-permission', 'PermissionRoleController@generatePermission')->middleware(['checkForDemoMode'])->name('generatePermission.index');
    Route::post('assign-permission', 'PermissionRoleController@assignPermission')->name('permissionRoles.assignPermission');

    // User
    Route::get('user/list', 'UserController@index')->name('users.index');
    Route::get('user/create', 'UserController@create')->name('users.create');
    Route::post('user/store', 'UserController@store')->middleware(['checkForDemoMode'])->name('users.store');
    Route::get('user/edit/{id}', 'UserController@edit')->name('users.edit');
    Route::post('user/updatePassword/{id}', 'UserController@updatePassword')->middleware(['checkForDemoMode'])->name('users.password');
    Route::post('user/update/{id}', 'UserController@update')->middleware(['checkForDemoMode'])->name('users.update');
    Route::post('user/delete/{id}', 'UserController@destroy')->name('users.destroy')->middleware(['checkForDemoMode']);
    Route::match(['GET', 'POST'], 'import/users', 'UserController@import')->name('epz.import.users');
    Route::get('user/pdf', 'UserController@pdf')->name('users.pdf');
    Route::get('user/csv', 'UserController@csv')->name('users.csv');
    Route::get('user/wallet/{id}', 'UserController@wallet')->name('user.wallet');
    Route::get('user/activity/', 'UserController@allUserActivity')->name('users.activity');
    Route::post('user/activity/delete/{id}', 'UserController@deleteUserActivity')->name('users.activity.delete');
    Route::get('user/customer', 'UserController@index')->name('users.customer');

    Route::post('user/update-profile/{id}', 'UserController@updateProfile')->name('users.updateProfile');
    Route::get('profile', 'UserController@profile')->name('users.profile');
    Route::post('user/update-profile-password/{id}', 'UserController@updateProfilePassword')->name('users.profilePassword');

    // Product
    Route::get('products', 'ProductController@index')->name('product.index');
    Route::get('product/edit/{code}', 'ProductController@edit')->name('product.edit');
    Route::match(['get', 'post'], '/product/create', 'ProductController@createProduct')->name('product.create');
    Route::match(['get', 'post'], '/product/edit/{code}/action', 'ProductController@editProductAction')->name('products.edit-action');
    Route::get('products/view/{id}', 'ProductController@view')->name('product.view');
    Route::delete('product/trash/{code}/action', 'ProductController@deleteProduct')->middleware(['checkForDemoMode'])->name('product.destroy');
    Route::delete('product/delete/{code}/action', 'ProductController@forceDeleteProduct')->middleware(['checkForDemoMode'])->name('product.force-delete');
    Route::get('pending/products', 'ProductController@index')->name('product.pending');

    //duplicate product
    Route::get('product/duplicate/{code}', 'ProductController@duplicate')->name('product.duplicate');

    // Vendor Admin Routes
    Route::get('vendors', 'VendorController@index')->name('vendors.index');
    Route::get('vendors/create', 'VendorController@create')->name('vendors.create');
    Route::post('vendors/store', 'VendorController@store')->name('vendors.store');
    Route::get('vendors/edit/{id}', 'VendorController@edit')->name('vendors.edit');
    Route::post('vendors/update/{id}', 'VendorController@update')->name('vendors.update');
    Route::post('vendors/delete/{id}', 'VendorController@destroy')->middleware(['checkForDemoMode'])->name('vendors.destroy');
    Route::match(['GET', 'POST'], 'vendors/import', 'VendorController@import')->name('vendors.import');
    Route::get('vendors/pdf', 'VendorController@pdf')->name('vendors.pdf');
    Route::get('vendors/csv', 'VendorController@csv')->name('vendors.csv');

    // Brand
    Route::get('brands', 'BrandController@index')->name('brands.index');
    Route::get('brands/create', 'BrandController@create')->name('brands.create');
    Route::post('brands/store', 'BrandController@store')->name('brands.store');
    Route::get('brands/edit/{id}', 'BrandController@edit')->name('brands.edit');
    Route::post('brands/update/{id}', 'BrandController@update')->name('brands.update');
    Route::post('brands/delete/{id}', 'BrandController@destroy')->middleware(['checkForDemoMode'])->name('brands.destroy');
    Route::get('brands/pdf', 'BrandController@pdf')->name('brands.pdf');
    Route::get('brands/csv', 'BrandController@csv')->name('brands.csv');

    // Attribute
    Route::get('attributes', 'AttributeController@index')->name('attribute.index');
    Route::get('attributes/create', 'AttributeController@create')->name('attribute.create');
    Route::post('attributes/store', 'AttributeController@store')->name('attribute.store');
    Route::get('attributes/edit/{id}', 'AttributeController@edit')->name('attribute.edit');
    Route::post('attributes/get-attribute', 'AttributeController@getAttribute');
    Route::post('attributes/update/{id}', 'AttributeController@update')->name('attribute.update');
    Route::delete('attributes/delete/{id}', 'AttributeController@destroy')->middleware(['checkForDemoMode'])->name('attribute.destroy');
    Route::get('attributes/pdf', 'AttributeController@pdf')->name('attribute.pdf');
    Route::get('attributes/csv', 'AttributeController@csv')->name('attribute.csv');

    // Attribute Group
    Route::get('attribute-groups', 'AttributeGroupController@index')->name('attributeGroup.index');
    Route::get('attribute-groups/create', 'AttributeGroupController@create')->name('attributeGroup.create');
    Route::post('attribute-groups/store', 'AttributeGroupController@store')->name('attributeGroup.store');
    Route::get('attribute-groups/edit/{id}', 'AttributeGroupController@edit')->name('attributeGroup.edit');
    Route::post('attribute-groups/update/{id}', 'AttributeGroupController@update')->name('attributeGroup.update');
    Route::delete('attribute-groups/delete/{id}', 'AttributeGroupController@destroy')->name('attributeGroup.destroy');
    Route::get('attribute-groups/pdf', 'AttributeGroupController@pdf')->name('attributeGroup.pdf');
    Route::get('attribute-groups/csv', 'AttributeGroupController@csv')->name('attributeGroup.csv');

    // Category
    Route::get('categories', 'CategoryController@index')->name('categories.index');
    Route::post('categories/store', 'CategoryController@store')->name('categories.store');
    Route::get('categories/get-data', 'CategoryController@getData');
    Route::post('categories/get-parent-data', 'CategoryController@getParentData');
    Route::post('categories/move-node', 'CategoryController@moveNode');
    Route::post('categories/edit', 'CategoryController@edit');
    Route::post('categories/update', 'CategoryController@update')->name('categories.update');
    Route::post('categories/delete', 'CategoryController@destroy')->middleware(['checkForDemoMode'])->name('categories.destroy');

    // Email Template
    Route::get('emailTemplate/list', 'MailTemplateController@index')->name('emailTemplates.index');
    Route::get('emailTemplate/create', 'MailTemplateController@create')->name('emailTemplates.create');
    Route::post('emailTemplate/store', 'MailTemplateController@store')->middleware(['checkForDemoMode'])->name('emailTemplates.store');
    Route::get('emailTemplate/edit/{id}', 'MailTemplateController@edit')->name('emailTemplates.edit');
    Route::post('emailTemplate/update/{id}', 'MailTemplateController@update')->middleware(['checkForDemoMode'])->name('emailTemplates.update');
    Route::post('emailTemplate/delete/{id}', 'MailTemplateController@destroy')->middleware(['checkForDemoMode'])->name('emailTemplates.destroy');

    // Preference
    Route::match(['GET', 'POST'], 'preference', 'PreferenceController@index')->name('preferences.index');
    Route::match(['GET', 'POST'], 'preference/password', 'PreferenceController@password')->name('preferences.password');

    // Email Configuration
    Route::match(['GET', 'POST'], 'email-setting', 'EmailConfigurationController@index')->name('emailConfigurations.index');

    // Company Settings
    Route::match(['GET', 'POST'], 'general-setting', 'CompanySettingController@index')->name('companyDetails.setting');

    Route::get('system-info', 'SystemInfoController@index')->name('systemInfo.index');

    // Language
    Route::get('languages/translation/{id}', 'LanguageController@translation')->name('language.translation');
    Route::get('languages', 'LanguageController@index')->name('language.index');
    Route::post('languages/save', 'LanguageController@store')->middleware(['checkForDemoMode'])->name('language.store');
    Route::post('languages/edit', 'LanguageController@edit');
    Route::post('languages/update', 'LanguageController@update')->middleware(['checkForDemoMode'])->name('language.update');
    Route::post('languages/delete/{id}', 'LanguageController@delete')->middleware(['checkForDemoMode'])->name('language.delete');
    Route::post('languages/translation/save', 'LanguageController@translationStore')->middleware(['checkForDemoMode'])->name('language.translationSave');

    // Currency
    Route::get('currencies', 'CurrencyController@index')->name('currency.index');
    Route::post('currencies/save', 'CurrencyController@store')->name('currency.store');
    Route::post('currencies/edit', 'CurrencyController@edit')->name('currency.edit');
    Route::post('currencies/update', 'CurrencyController@update')->name('currency.update');
    Route::post('currencies/delete/{id}', 'CurrencyController@destroy')->name('currency.delete');
    Route::get('currencies/valid', 'CurrencyController@validCurrencyName');

    // Review
    Route::get('reviews', 'ReviewController@index')->name('review.index');
    Route::post('reviews/edit', 'ReviewController@edit')->name('review.edit');
    Route::get('reviews/view/{id}', 'ReviewController@view')->name('review.view');
    Route::post('reviews/update', 'ReviewController@update')->name('review.update');
    Route::post('reviews/delete/{id}', 'ReviewController@destroy')->name('review.destroy');
    Route::get('reviews/pdf', 'ReviewController@pdf')->name('review.pdf');
    Route::get('reviews/csv', 'ReviewController@csv')->name('review.csv');

    // SSO Service
    Route::match(['GET', 'POST'], 'sso-service', 'SsoController@index')->name('sso.index');

    // Maintenance mode
    Route::match(['GET', 'POST'], 'maintenance-mode', 'MaintenanceModeController@enable')->name('maintenance.enable');

    // Order status
    Route::get('order-statuses', 'OrderStatusController@index')->name('orderStatues.index');
    Route::post('order-statuses/save', 'OrderStatusController@store')->middleware(['checkForDemoMode'])->name('orderStatues.store');
    Route::post('order-statuses/edit', 'OrderStatusController@edit');
    Route::post('order-statuses/update', 'OrderStatusController@update')->middleware(['checkForDemoMode'])->name('orderStatues.update');
    Route::post('order-statuses/delete/{id}', 'OrderStatusController@destroy')->middleware(['checkForDemoMode'])->name('orderStatues.delete');

    // Order
    Route::get('orders', 'AdminOrderController@index')->name('order.index');
    Route::get('orders/view/{id}', 'AdminOrderController@view')->name('order.view');
    Route::post('orders/change-status', 'AdminOrderController@changeStatus');
    Route::post('orders/update', 'AdminOrderController@update')->name('order.update');
    Route::delete('orders/delete/{id}', 'AdminOrderController@destroy')->middleware(['checkForDemoMode'])->name('order.destroy');
    Route::get('orders/pdf', 'AdminOrderController@pdf')->name('order.pdf');
    Route::get('orders/csv', 'AdminOrderController@csv')->name('order.csv');
    Route::get('invoice/print/{id}', 'AdminOrderController@invoicePrint')->name('invoice.print');

    // Transaction
    Route::get('transactions', 'TransactionController@index')->name('transaction.index');
    Route::get('transaction/edit/{id}', 'TransactionController@edit')->name('transaction.edit');
    Route::post('transaction/update/{id}', 'TransactionController@update')->name('transaction.update');
    Route::get('transactions/pdf', 'TransactionController@pdf')->name('transaction.pdf');
    Route::get('transactions/csv', 'TransactionController@csv')->name('transaction.csv');

    // Withdrawal
    Route::get('withdrawals', 'WithdrawalController@index')->name('withdrawal.index');
    Route::get('withdrawal/edit/{id}', 'WithdrawalController@edit')->name('withdrawal.edit');
    Route::post('withdrawal/update/{id}', 'WithdrawalController@update')->name('withdrawal.update');
    Route::get('withdrawals/pdf', 'WithdrawalController@pdf')->name('withdrawal.pdf');
    Route::get('withdrawals/csv', 'WithdrawalController@csv')->name('withdrawal.csv');

    // Addons Manager
    Route::get('addons', 'AddonsMangerController@index')->name('addon.index');

    // Dashboard route
    Route::get('/user/{uid}/getinfo/{type}', 'DashboardController@getUserData')->name('users.user-data');
    Route::get('/product/{uid}/getinfo', 'DashboardController@getProductData')->name('products.product-data');
    Route::get('/get-most-sold-products', 'DashboardController@mostSoldProducts')->name('dashboard.most-sold-products');
    Route::get('/get-active-users', 'DashboardController@mostActiveUsers')->name('dashboard.most-active-users');
    Route::get('/vendor-stats', 'DashboardController@vendorStats')->name('dashboard.vendor-stats');
    Route::get('/vendor-stats/{type}', 'DashboardController@vendorStatsType')->name('dashboard.vendor-stats-type');
    Route::get('/vendor-req', 'DashboardController@vendorReq')->name('dashboard.vendor-req');
    Route::get('/sales-of-the-month', 'DashboardController@salesOfTheMonth')->name('dashboard.sales-of-this-month');
    Route::get('user/change-status/{status}/{id}', 'DashboardController@changeStatus')->name('dashboard.changeStatus');

    // Email
    Route::get('verify-email-setting', 'EmailController@emailVerifySetting')->name('emailVerifySetting');
    Route::post('verify-email-setting', 'EmailController@emailVerifySetting')->middleware(['checkForDemoMode'])->name('emailVerifySetting');

    // Product Setting
    Route::match(['GET', 'POST'], 'product-setting', 'ProductSettingController@general')->name('product.setting.general');
    Route::post('product-setting/inventory', 'ProductSettingController@inventory')->name('product.setting.inventory');
    Route::post('product-setting/vendor', 'ProductSettingController@vendor')->name('product.setting.vendor');

    //Order Setting
    Route::match(['GET', 'POST'], 'order-setting', 'OrderSettingController@index')->name('order.setting.option');

    //Invoice Setting
    Route::match(['GET', 'POST'], 'invoice-setting', 'InvoiceSettingController@index')->name('invoice.setting.option');

    //Account Setting
    Route::match(['GET', 'POST'], 'account-setting', 'AccountSettingController@index')->name('account.setting.option');

    // downloadable products
    Route::get('/find-downloadable-products-with-ajax', 'ProductController@findDownloadProducts')->name('findDownloadProducts');

    // grant access
    Route::post('/grant-access-with-ajax', 'AdminOrderController@grantAccess')->name('grantAccess');

    /**
     * Test routes
     */
    Route::get('user/verify/{token}', 'UserController@verification')->name('users.verify');

    // Get users by search key
    Route::get('find-users-with-ajax', 'UserController@findUser')->name('find.users.ajax');

    // Get vendors by search key
    Route::get('find-vendors-with-ajax', 'VendorController@findVendor');

    // Import/Exports
    Route::get('/imports', [ImportController::class, 'index'])->name('epz.imports');
    Route::match(['GET', 'POST'], '/import/products', [ImportController::class, 'productImport'])->name('epz.import.products');

    // Export
    Route::get('/exports', [ExportController::class, 'index'])->name('epz.exports');
    Route::match(['GET', 'POST'], '/export/products', [ExportController::class, 'productExport'])->name('epz.export.products');

    Route::get('/find-currency-in-ajax', 'CurrencyController@findCurrencyAjaxQuery')->name('findCurrencyAjax');

    Route::post('/batch/delete', 'BatchController@destroy')->name('admin.batch_delete');

    Route::get('sms/configs', 'SmsConfigurationController@index')->name('sms.config.index');

    Route::get('sms/configs/twilio', 'SmsConfigurationController@twilio')->name('sms.config.twilio.index');
    Route::post('sms/configs/twilio', 'SmsConfigurationController@storeTwilio')->name('sms.config.twilio.update');

    Route::get('sms/configs/nexmo', 'SmsConfigurationController@nexmo')->name('sms.config.nexmo.index');
    Route::post('sms/configs/nexmo', 'SmsConfigurationController@storeNexmo')->name('sms.config.nexmo.update');

    Route::get('sms/configs/fast2sms', 'SmsConfigurationController@fast2Sms')->name('sms.config.fast2sms.index');
    Route::post('sms/configs/fast2sms', 'SmsConfigurationController@storeFast2Sms')->name('sms.config.fast2sms.update');

    Route::get('sms/configs/sslwireless', 'SmsConfigurationController@sslWireless')->name('sms.config.sslwireless.index');
    Route::post('sms/configs/sslwireless', 'SmsConfigurationController@storeSslWireless')->name('sms.config.sslwireless.update');

    Route::get('sms/configs/mim-sms', 'SmsConfigurationController@mimSms')->name('sms.config.mim_sms.index');
    Route::post('sms/configs/mim-sms', 'SmsConfigurationController@storeMimSms')->name('sms.config.mim_sms.update');

    Route::get('sms/configs/msegat', 'SmsConfigurationController@msegat')->name('sms.config.msegat.index');
    Route::post('sms/configs/msegat', 'SmsConfigurationController@storeMsegat')->name('sms.config.msegat.update');

    Route::get('sms/configs/sparrow', 'SmsConfigurationController@sparrow')->name('sms.config.sparrow.index');
    Route::post('sms/configs/sparrow', 'SmsConfigurationController@storeSparrow')->name('sms.config.sparrow.update');

    Route::get('sms/configs/zender', 'SmsConfigurationController@zender')->name('sms.config.zender.index');
    Route::post('sms/configs/zender', 'SmsConfigurationController@storeZender')->name('sms.config.zender.update');

    Route::get('sms/templates', 'SmsTemplateController@index')->name('sms.template.index');
    Route::get('sms/templates/{slug}', 'SmsTemplateController@edit')->name('sms.template.edit');
    Route::put('sms/templates/{id}', 'SmsTemplateController@update')->name('sms.template.update');

    Route::get('notifications', 'NotificationController@index')->name('notifications.index');
    Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
    Route::get('notifications/mark-as-read', 'NotificationController@markAsReadAll')->name('notifications.mark_read_all');
    Route::patch('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_read');
    Route::patch('notifications/mark-as-unread/{id}', 'NotificationController@markAsUnread')->name('notifications.mark_unread');
    Route::get('notifications/ajax-loading', 'NotificationController@headerNotification')->name('notifications.ajax-loading');
    Route::get('notifications/view/{id}', 'NotificationController@view')->name('notifications.view');

    Route::get('notifications/log', 'NotificationController@log')->name('notifications.log');
    Route::delete('notifications/log/{id}', 'NotificationController@destroyLog')->name('notifications.log.destroy');
    
    Route::get('notifications/setting', 'NotificationController@setting')->name('notifications.setting');
    Route::post('notifications/setting', 'NotificationController@updateSetting')->name('notifications.setting.update');

    //barcode
    Route::match(['get', 'post'], '/barcode/product', 'BarcodeController@product')->name('barcode.product');
    Route::match(['get', 'post'], '/barcode/settings', 'BarcodeController@settings')->name('barcode.settings');
    Route::match(['get', 'post'], '/barcode/product-search', 'BarcodeController@search')->name('barcode.product.search');
});

Route::group(['middleware' => ['isLoggedIn']], function () {
    Route::get('files/download/{id}', 'FilesController@downloadAttachment');
    Route::post('change-lang', 'DashboardController@switchLanguage')->middleware(['checkForDemoMode']);

    Route::get('is-valid-file-size', 'FilesController@isValidFileSize');
});

Route::get('/find-products-in-ajax', 'ProductController@findProductAjaxQuery')->name('findProductsAjax');
Route::get('/find-tags-in-ajax', 'ProductController@findTagsAjaxQuery')->name('findTagsAjax');

// Test Routes
Route::get('/product/{code}/json', 'ProductController@productJson');
