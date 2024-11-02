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

Route::post('/login', 'AuthController@login');
Route::post('password/reset-link', 'AuthController@sendResetLinkEmail');
Route::post('password/reset', 'AuthController@setPassword');
Route::get('user/verification/{otp}', 'AuthController@verifyEmail');
Route::group(['middleware' => ['auth:api', 'locale', 'permission-api']], function () {
    // User
    Route::get('/logout', 'AuthController@logout');
    Route::get('user/list', 'UserController@index');
    Route::post('user/store', 'UserController@store');
    Route::get('user/view/{id}', 'UserController@detail');
    Route::post('user/update/{id}', 'UserController@update');
    Route::post('user/update-password/{id}', 'UserController@updatePassword');
    Route::post('user/delete/{id}', 'UserController@destroy');

    // Role
    Route::get('role/list', 'RoleController@index');
    Route::post('role/store', 'RoleController@store');
    Route::get('role/view/{id}', 'RoleController@detail');
    Route::post('role/update/{id}', 'RoleController@update');
    Route::post('role/delete/{id}', 'RoleController@destroy');

    // Email Template
    Route::get('emailTemplate/list', 'MailTemplateController@index');
    Route::post('emailTemplate/store', 'MailTemplateController@store');
    Route::post('emailTemplate/view/{id}', 'MailTemplateController@detail');
    Route::post('emailTemplate/update/{id}', 'MailTemplateController@update');
    Route::post('emailTemplate/delete/{id}', 'MailTemplateController@destroy');

    // Preference
    Route::match(['GET', 'POST'], 'preference', 'PreferenceController@index');

    // Email Configuration
    Route::match(['GET', 'POST'], 'emailConfiguration', 'EmailConfigurationController@index');

    // Company Setting
    Route::match(['GET', 'POST'], 'companySetting', 'CompanySettingController@index');

    // Currency
    Route::get('currency/list', 'CurrencyController@index');
    Route::post('currency/store', 'CurrencyController@store');
    Route::post('currency/update/{id}', 'CurrencyController@update');
    Route::get('currency/view/{id}', 'CurrencyController@detail');
    Route::delete('currency/delete/{id}', 'CurrencyController@destroy');

    // Brand
    Route::get('brand/list', 'BrandController@index');
    Route::post('brand/store', 'BrandController@store');
    Route::post('brand/update/{id}', 'BrandController@update');
    Route::get('brand/view/{id}', 'BrandController@detail');
    Route::post('brand/delete/{id}', 'BrandController@destroy');

    // Vendor
    Route::get('vendor/list', 'VendorController@index');
    Route::post('vendor/store', 'VendorController@store');
    Route::post('vendor/update/{id}', 'VendorController@update');
    Route::get('vendor/view/{id}', 'VendorController@detail');
    Route::post('vendor/delete/{id}', 'VendorController@destroy');

    // Product
    Route::get('products', 'ProductController@index');
    Route::post('product/search/{type}', 'ProductController@search');
    Route::get('product/view/{id}', 'ProductController@detail');
    Route::post('product/delete/{id}', 'ProductController@deleteProduct');

    // Category
    Route::get('categories', 'CategoryController@index');
    Route::post('category/store', 'CategoryController@store');
    Route::post('category/update/{id}', 'CategoryController@update');
    Route::get('category/view/{id}', 'CategoryController@detail');
    Route::post('category/delete/{id}', 'CategoryController@destroy');

    // product update
    Route::post('product/update', 'ProductController@update');

    //user preference for POS
    Route::post('user/store-meta/{id}', 'UserController@storeMeta');
    Route::get('user/get-meta/{id}', 'UserController@getMeta');
});

// Country list
Route::get('country', 'CountryController@index');

// Preference for App
Route::get('preferences', 'PreferenceController@preference');

// Vendor specification
Route::get('vendor/{id}', 'VendorController@detail');
