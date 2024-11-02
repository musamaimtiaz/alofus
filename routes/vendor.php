<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 07-10-2021
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'locale', 'permission']], function () {
    // Vendor Dashboard Routes
    Route::get('dashboard', 'DashboardController@index')->name('vendor-dashboard');
    Route::post('dashboard/widget', 'DashboardController@setWidgetData');
    Route::post('dashboard/widget/option', 'DashboardController@setWidgetOption');
    Route::get('dashboard/widget/forget-cache', 'DashboardController@forgetWidget')->name('vendor.dashboard.forget_widget');

    // Vendor
    Route::get('profile', 'VendorController@profile')->name('vendor.profile');
    Route::post('profile-update/{id}', 'VendorController@update')->name('user.update');
    Route::post('vendor-update/{id}', 'VendorController@updateVendor')->name('vendor.update');
    Route::post('update-password/{id}', 'VendorController@updatePassword')->name('vendor.password');
    Route::get('logout', 'VendorController@logout')->name('vendor.logout');

    // Product
    Route::get('products', 'ProductController@index')->name('vendor.products');
    Route::get('product/edit/{code}', 'ProductController@edit')->name('vendor.product.edit');
    Route::match(['get', 'post'], '/product/create', 'ProductController@createProduct')->name('vendor.product.create');
    Route::match(['get', 'post'], '/product/edit/{code}/action', 'ProductController@editProductAction')->name('vendor.product.edit-action');
    Route::delete('product/trash/{code}/action', 'ProductController@deleteProduct')->name('vendor.product.destroy');
    Route::delete('product/delete/{code}/action', 'ProductController@forceDeleteProduct')->name('vendor.product.force-delete');
    Route::get('/find-products-in-ajax', 'ProductController@findProductAjaxQuery')->name('vendor.findProductsAjax');
    Route::get('/find-tags-in-ajax', 'ProductController@findTagsAjaxQuery')->name('vendor.findTagsAjax');
    Route::post('products/search/{type}', 'ProductController@search')->name('vendor.product.search');

    //duplicate product
    Route::get('product/duplicate/{code}', 'ProductController@duplicate')->name('vendor.product.duplicate');

    // Review
    Route::get('reviews', 'ReviewController@index')->name('vendor.reviews');
    Route::post('reviews/edit', 'ReviewController@edit')->name('vendor.reviewEdit');
    Route::get('reviews/view/{id}', 'ReviewController@view')->name('vendor.reviewView');
    Route::post('reviews/update', 'ReviewController@update')->name('vendor.reviewUpdate');
    Route::post('reviews/delete/{id}', 'ReviewController@destroy')->name('vendor.reviewDestroy');
    Route::get('reviews/pdf', 'ReviewController@pdf')->name('vendor.reviewPdf');
    Route::get('reviews/csv', 'ReviewController@csv')->name('vendor.reviewCsv');

    // Order
    Route::get('orders', 'VendorOrderController@index')->name('vendorOrder.index');
    Route::get('orders/view/{id}', 'VendorOrderController@view')->name('vendorOrder.view');
    Route::post('orders/change-status', 'VendorOrderController@changeStatus')->name('vendorOrder.update');
    Route::get('orders/pdf', 'VendorOrderController@pdf')->name('vendorOrder.pdf');
    Route::get('orders/csv', 'VendorOrderController@csv')->name('vendorOrder.csv');
    Route::get('invoice/print/{id}', 'VendorOrderController@invoicePrint')->name('vendorInvoice.print');
    Route::post('store-note', 'VendorOrderController@storeNote');
    Route::post('order/actions', 'VendorOrderController@orderAction');

    // Withdrawal
    Route::get('withdrawals', 'WithdrawalController@index')->name('vendorWithdrawal.index');
    Route::match(['get', 'post'], 'withdrawal/setting', 'WithdrawalController@setting')->name('vendorWithdrawal.setting');
    Route::match(['get', 'post'], 'withdraw/money', 'WithdrawalController@withdraw')->name('vendorWithdrawal.money');
    Route::get('withdrawals/pdf', 'WithdrawalController@pdf')->name('vendorWithdrawal.pdf');
    Route::get('withdrawals/csv', 'WithdrawalController@csv')->name('vendorWithdrawal.csv');

    // Transactions
    Route::get('transactions', 'VendorTransactionController@index')->name('vendorTransaction.index');
    Route::get('transactions/pdf', 'VendorTransactionController@pdf')->name('vendorTransaction.pdf');
    Route::get('transactions/csv', 'VendorTransactionController@csv')->name('vendorTransaction.csv');

    // downloadable products
    Route::get('/find-downloadable-products-with-ajax', 'ProductController@findDownloadProducts');

    // grant access
    Route::post('/grant-access-with-ajax', 'VendorOrderController@grantAccess')->name('vendor.grantAccess');

    Route::name('vendor.')->group(function () {
        Route::get('/user/{uid}/getinfo', 'DashboardController@getUserData')->name('users.user-data');
        Route::get('/product/{uid}/getinfo', 'DashboardController@getProductData')->name('products.product-data');
        Route::get('/get-most-sold-products', 'DashboardController@mostSoldProducts')->name('dashboard.most-sold-products');
        Route::get('/get-active-users', 'DashboardController@mostActiveUsers')->name('dashboard.most-active-users');
        Route::get('/vendor-stats', 'DashboardController@vendorStats')->name('dashboard.vendor-stats');
        Route::get('/sales-of-the-month', 'DashboardController@salesOfTheMonth')->name('dashboard.sales-of-this-month');

        // Import routes
        Route::match(['GET', 'POST'], '/import/products', 'ImportController@productImport')->name('epz.import.products');

        // Export products
        Route::match(['GET', 'POST'], '/export/products', 'ExportController@productExport')->name('epz.export.products');

        //barcode
        Route::match(['get', 'post'], '/barcode/product', 'BarcodeController@product')->name('barcode.product');
        Route::match(['get', 'post'], '/barcode/product-search', 'BarcodeController@search')->name('barcode.product.search');
    });

    //activity
    Route::get('/activity', 'VendorController@loginActivity')->name('vendor.loginActivity');

    Route::name('vendor.')->group(function () {
        Route::get('all-categories', 'CategoryController@index')->name('categories.index');
        Route::post('categories/store', 'CategoryController@store')->name('categories.store');
        Route::get('categories/get-data', 'CategoryController@getData');
        Route::post('categories/get-parent-data', 'CategoryController@getParentData');
        Route::post('categories/move-node', 'CategoryController@moveNode');
        Route::post('categories/edit', 'CategoryController@edit');
        Route::post('categories/update', 'CategoryController@update')->name('categories.update');
        Route::post('categories/delete', 'CategoryController@destroy')->middleware(['checkForDemoMode'])->name('categories.destroy');
        Route::get('categories/suggestion', 'CategoryController@suggestion');
        Route::post('categories/assign-vendor', 'CategoryController@assignCategory');
    });

    // customer
    Route::get('customer', 'CustomerController@index')->name('vendor.customer');

    Route::name('vendor.')->group(function () {
        Route::get('notifications', 'NotificationController@index')->name('notifications.index');
        Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
        Route::get('notifications/mark-as-read', 'NotificationController@markAsReadAll')->name('notifications.mark_read_all');
        Route::patch('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_read');
        Route::patch('notifications/mark-as-unread/{id}', 'NotificationController@markAsUnread')->name('notifications.mark_unread');
        Route::get('notifications/ajax-loading', 'NotificationController@headerNotification')->name('notifications.ajax-loading');
    });

});
