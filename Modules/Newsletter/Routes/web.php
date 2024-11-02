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

Route::group(['namespace' => 'Modules\Newsletter\Http\Controllers', 'middleware' => ['locale', 'web']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('subscribers', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/edit/{id}', 'SubscriberController@edit')->name('subscriber.edit');
        Route::post('subscriber/update/{id}', 'SubscriberController@update')->name('subscriber.update');
        Route::post('subscriber/delete/{id}', 'SubscriberController@destroy')->middleware(['checkForDemoMode'])->name('subscriber.delete');
        Route::get('subscribers/pdf', 'SubscriberController@pdf')->name('subscriber.pdf');
        Route::get('subscribers/csv', 'SubscriberController@csv')->name('subscriber.csv');

    });

    Route::post('subscriber/store', 'SubscriberController@store')->name('subscriber.store');
    Route::get('subscription/{id}', 'SubscriberController@unsubscribe')->name('subscription.destroy');
});
