<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api', 'locale', 'permission-api']], function () {

    // Product
    Route::get('products', 'ApiVendorProductController@index');
    Route::post('product/store', 'ApiVendorProductController@store');
    Route::post('product/update/{id}', 'ApiVendorProductController@update');
    Route::post('product/search/{type}', 'ApiVendorProductController@search');
    Route::get('product/view/{id}', 'ApiVendorProductController@detail');
    Route::post('product/related/update/{type}', 'ApiVendorProductController@updateRelatedProduct');
    Route::post('product/delete/{id}', 'ApiVendorProductController@destroy');
});
