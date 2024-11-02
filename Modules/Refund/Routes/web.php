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

Route::group(['middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Refund\Http\Controllers'], function () {
        // Admin Refund
        Route::get('/refund-requests', 'RefundController@index')->name('refund.index');
        Route::get('/refund-request/edit/{id}', 'RefundController@edit')->name('refund.edit');
        Route::post('/refund-request/update', 'RefundController@update')->name('refund.update');
        Route::get('/refund-request/pdf', 'RefundController@pdf')->name('refund.pdf');
        Route::get('/refund-request/csv', 'RefundController@csv')->name('refund.csv');
    });

    Route::group(['prefix' => 'vendor', 'namespace' => 'Modules\Refund\Http\Controllers\Vendor'], function () {
        // Vendor Refund
        Route::get('/refund-requests', 'RefundController@index')->name('vendor.refund.index');
        Route::get('/refund-request/edit/{id}', 'RefundController@edit')->name('vendor.refund.edit');
        Route::post('/refund-request/update', 'RefundController@update')->name('vendor.refund.update');
        Route::get('/refund-request/pdf', 'RefundController@pdf')->name('vendor.refund.pdf');
        Route::get('/refund-request/csv', 'RefundController@csv')->name('vendor.refund.csv');

        Route::post('/refund-process', 'RefundProcessController@process')->name('vendor.refundProcess');
    });
});

Route::group(['prefix' => 'user', 'namespace' => 'Modules\Refund\Http\Controllers\Site', 'middleware' => ['site.auth', 'locale', 'permission', 'web']], function () {
    // User Refund
    Route::get('refund-request', 'RefundController@index')->name('site.refundRequest');
    Route::get('create-refund-request', 'RefundController@createRequest')->name('site.createRefundRequest');
    Route::post('order-refund', 'RefundController@refund')->name('site.orderRefund');
    Route::get('refund-details/{id}', 'RefundController@refundDetails')->name('site.refundDetails');

    Route::get('refund-products/{reference}', 'RefundController@getProducts')->name('site.refund.products');
    Route::post('refund-process', 'RefundProcessController@process')->name('site.refundProcess');
});

Route::group(['prefix' => 'api/user', 'namespace' => 'Modules\Refund\Http\Controllers\Api\User', 'middleware' => ['auth:api', 'locale', 'permission-api', 'api']], function () {
    // User Refund API
    Route::get('refunds', 'RefundController@index');
    Route::get('refunds/reasons', 'RefundController@getReason');
    Route::post('refunds', 'RefundController@store');
    Route::get('refunds/{id}', 'RefundController@details');
    Route::post('refunds/{id}/messages', 'RefundController@storeMessage');
    Route::get('refunds/{id}/messages', 'RefundController@getMessage');
});
