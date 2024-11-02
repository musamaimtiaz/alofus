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

use App\Http\Middleware\VerifyCsrfToken;

Route::group([
    'prefix' => 'gateway',
    'as' => 'gateway.',
    'namespace' => 'Modules\Gateway\Http\Controllers',
    'middleware' => ['locale', 'web'],
], function () {
    Route::get('payment/confirmation', 'GatewayController@paymentConfirmation')->name('confirmation');
    Route::get('payment/failed-payment', 'GatewayController@paymentFailed')->name('failed');
    Route::get('/payment', 'GatewayController@paymentGateways')->name('payment');
    Route::get('/payment/{gateway}/pay', 'GatewayController@pay')->name('pay');
    Route::post('/pay/{gateway}/complete', 'GatewayController@makePayment')->name('complete');
    Route::match(['get', 'post'], '/pay/{gateway}/callback', 'GatewayController@paymentCallback')->name('callback');
    Route::match(['get', 'post'], '/pay/{gateway}/cancelled', 'GatewayController@paymentCancelled')->name('cancel');
    Route::post('/pay/{gateway}/payment_webhook', 'GatewayController@paymentHook')
        ->withoutMiddleware([VerifyCsrfToken::class, 'site.auth'])->name('webhook');
    Route::group(['middleware' => ['auth', 'permission']], function () {
        Route::get('enable-module', 'GatewayController@enableModule')->name('enable-module');
        Route::get('disable-module', 'GatewayController@disableModule')->name('disable-module');
    });
});
