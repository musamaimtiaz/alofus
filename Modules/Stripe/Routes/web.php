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

Route::group(['prefix' => 'gateway/stripe', 'as' => 'stripe.', 'namespace' => 'Modules\Stripe\Http\Controllers', 'middleware' => ['auth', 'permission', 'locale', 'web']], function () {
    Route::post('/store', 'StripeController@store')->name('store')->middleware('checkForDemoMode');
    Route::get('/edit', 'StripeController@edit')->name('edit');
});
