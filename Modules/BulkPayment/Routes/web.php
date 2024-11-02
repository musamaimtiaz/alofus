<?php

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

Route::group(['prefix' => 'admin/bulk-payment', 'namespace' => 'Modules\BulkPayment\Http\Controllers', 'middleware' => ['auth', 'locale', 'web', 'permission']], function () {
    Route::match(['get', 'post'], '/order', 'BulkPaymentController@order')->name('bulk.payment.order');
});

Route::group(['prefix' => 'vendor/bulk-payment', 'as' => 'vendor.', 'namespace' => 'Modules\BulkPayment\Http\Controllers\Vendor', 'middleware' => ['auth', 'locale', 'web', 'permission']], function () {
    Route::match(['get', 'post'], '/order', 'BulkPaymentController@order')->name('bulk.payment.order');
});
