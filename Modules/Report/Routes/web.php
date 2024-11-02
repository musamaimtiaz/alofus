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

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Report\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::get('reports', 'ReportController@index')->name('reports');
});

Route::group(['prefix' => 'vendor', 'namespace' => 'Modules\Report\Http\Controllers\Vendor', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::get('reports', 'ReportController@index')->name('vendor.reports');
});
