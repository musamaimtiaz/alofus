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

Route::group(['namespace' => '\Modules\Coupon\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::group(['prefix' => 'admin'], function () {
        // Coupon
        Route::get('coupons', 'CouponController@index')->name('coupon.index');
        Route::get('coupon/create', 'CouponController@create')->name('coupon.create');
        Route::post('coupon/store', 'CouponController@store')->middleware(['checkForDemoMode'])->name('coupon.store');
        Route::get('coupon/edit/{id}', 'CouponController@edit')->name('coupon.edit');
        Route::post('coupon/update/{id}', 'CouponController@update')->name('coupon.update');
        Route::post('coupon/destroy/{id}', 'CouponController@destroy')->middleware(['checkForDemoMode'])->name('coupon.delete');
        Route::get('coupon/pdf', 'CouponController@downloadPdf')->name('coupon.pdf');
        Route::get('coupon/csv', 'CouponController@downloadCsv')->name('coupon.csv');
        Route::get('coupon/shop/{id}', 'CouponController@getShopByVendor')->name('coupon.shop');
        Route::get('coupon/item/{id}', 'CouponController@getCouponProduct')->name('coupon.item');

        Route::get('coupon/old-products', 'CouponController@getOldProducts')->name('coupon.oldProducts');
        Route::get('coupon/old-vendor', 'CouponController@getOldVendor');

        // Coupon Redeem
        Route::get('coupon-redeems', 'CouponRedeemController@index')->name('couponRedeem.index');
        Route::get('coupon-redeem/pdf', 'CouponRedeemController@pdf')->name('couponRedeem.pdf');
        Route::get('coupon-redeem/csv', 'CouponRedeemController@csv')->name('couponRedeem.csv');
    });

    Route::group(['namespace' => 'Vendor', 'prefix' => 'vendor'], function () {
        // Vendor Coupon
        Route::get('coupons', 'CouponController@index')->name('vendor.coupons');
        Route::get('coupon/create', 'CouponController@create')->name('vendor.couponCreate');
        Route::post('coupon/store', 'CouponController@store')->name('vendor.couponStore');
        Route::get('coupon/edit/{id}', 'CouponController@edit')->name('vendor.couponEdit');
        Route::post('coupon/update/{id}', 'CouponController@update')->name('vendor.couponUpdate');
        Route::post('coupon/destroy/{id}', 'CouponController@destroy')->name('vendor.couponDelete');
        Route::get('coupon/pdf', 'CouponController@pdf')->name('vendor.couponPdf');
        Route::get('coupon/csv', 'CouponController@csv')->name('vendor.couponCsv');
        Route::get('coupon/shop-item/{id}', 'CouponController@item')->name('vendor.couponProduct');
    });
});

Route::group(['prefix' => 'api', 'namespace' => 'Modules\Coupon\Http\Controllers\Api', 'middleware' => ['auth:api', 'locale', 'permission', 'api']], function () {
    // Coupon
    Route::get('coupon/list', 'CouponController@index');
    Route::post('coupon/store', 'CouponController@store');
    Route::post('coupon/update/{id}', 'CouponController@update');
    Route::get('coupon/view/{id}', 'CouponController@detail');
    Route::delete('coupon/delete/{id}', 'CouponController@destroy');
});
