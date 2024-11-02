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

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Commission\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::get('commission', 'CommissionController@index')->name('commission.index');
    Route::post('commission/store', 'CommissionController@store')->name('commission.store');
});
