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

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Tax\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::get('taxes', 'TaxClassController@index')->name('tax.index');
    Route::post('tax/store', 'TaxClassController@store')->middleware(['checkForDemoMode'])->name('tax.store');
    Route::post('tax/update', 'TaxClassController@update')->middleware(['checkForDemoMode'])->name('tax.update');
    Route::post('tax/delete/{id}', 'TaxClassController@destroy')->middleware(['checkForDemoMode'])->name('tax.delete');
    Route::post('tax-setting/update', 'TaxClassController@setting')->middleware(['checkForDemoMode'])->name('tax_setting.update');

    Route::post('tax-rate/update', 'TaxRateController@update')->middleware(['checkForDemoMode'])->name('tax_rate.update');
});

Route::group(['prefix' => 'api', 'namespace' => 'Modules\Tax\Http\Controllers\Api', 'middleware' => ['auth:api', 'locale', 'permission', 'api']], function () {
    // Tax Class
    Route::get('taxes/classes', 'TaxClassController@index');
    Route::post('taxes/classes', 'TaxClassController@store');
    Route::delete('taxes/classes/{slug}', 'TaxClassController@destroy');

    // Tax Rate
    Route::get('taxes', 'TaxRateController@index');
    Route::post('taxes', 'TaxRateController@store');
    Route::get('taxes/{id}', 'TaxRateController@detail');
    Route::post('taxes/{id}', 'TaxRateController@update');
    Route::delete('taxes/{id}', 'TaxRateController@destroy');
});
