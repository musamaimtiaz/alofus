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
    Route::prefix('admin')->namespace('Modules\CMS\Http\Controllers')->group(function () {
        Route::get('page/list', 'CMSController@index')->name('page.index');
        Route::get('/page/home/list', 'CMSController@home')->name('page.home');
        Route::get('page/create', 'CMSController@create')->name('page.create');
        Route::get('page/home/create', 'CMSController@createHomepage')->name('page.home.create');
        Route::post('page/store', 'CMSController@store')->name('page.store');
        Route::get('page/edit/{slug}', 'CMSController@edit')->name('page.edit');
        Route::get('page/home/edit/{slug}', 'CMSController@editHome')->name('page.home.edit');
        Route::get('page/home/export/{slug}', 'CMSController@exportHome')->name('page.home.export');
        Route::post('page/home/import/', 'CMSController@importHome')->middleware(['checkForDemoMode'])->name('page.home.import');
        Route::post('page/home/update/{id}', 'CMSController@quickUpdate')->middleware(['checkForDemoMode'])->name('page.home.quick-update');
        Route::post('page/update/{id}', 'CMSController@update')->middleware(['checkForDemoMode'])->name('page.update');
        Route::post('page/delete/{id}', 'CMSController@delete')->middleware(['checkForDemoMode'])->name('page.delete');

        // Theme Option
        Route::get('theme/list', 'ThemeOptionController@list')->name('theme.index');
        Route::post('theme/store', 'ThemeOptionController@store')->name('theme.store')->middleware(['checkForDemoMode']);
        Route::post('theme-layout/store', 'ThemeOptionController@layoutStore')->middleware(['checkForDemoMode'])->name('theme.layout.store');
        Route::post('theme/store/primary-color', 'ThemeOptionController@storePrimaryColor')->middleware(['checkForDemoMode']);
        Route::post('theme-layout/update', 'ThemeOptionController@layoutUpdate')->middleware(['checkForDemoMode'])->name('theme.layout.update');
        Route::post('theme-layout/delete/{layout}', 'ThemeOptionController@layoutDelete')->middleware(['checkForDemoMode'])->name('theme.layout.delete');

        // Slide
        Route::get('slide/create', 'SlideController@create')->name('slide.create');
        Route::post('slide/store', 'SlideController@store')->middleware(['checkForDemoMode'])->name('slide.store');
        Route::get('slide/edit/{id}', 'SlideController@edit')->name('slide.edit');
        Route::post('slide/update/{id}', 'SlideController@update')->middleware(['checkForDemoMode'])->name('slide.update');
        Route::post('slide/delete/{id}', 'SlideController@delete')->middleware(['checkForDemoMode'])->name('slide.delete');

        // Slider
        Route::get('sliders', 'SliderController@index')->name('slider.index');
        Route::post('slider/store', 'SliderController@store')->middleware(['checkForDemoMode'])->name('slider.store');
        Route::post('slider/update', 'SliderController@update')->middleware(['checkForDemoMode'])->name('slider.update');
        Route::post('slider/delete/{id}', 'SliderController@delete')->middleware(['checkForDemoMode'])->name('slider.delete');
    });
    Route::prefix('admin')->namespace('Modules\CMS\Http\Controllers')->group(function () {
        // Page builder
        Route::get('page/builder/{slug}', 'BuilderController@edit')->name('builder.edit');
        Route::match(['get', 'post'], 'page/builder/edit/{file}', 'BuilderController@editElement')->name('builder.form');
        Route::post('page/builder/edit/{id}/component', 'BuilderController@updateComponent')->name('builder.update');
        Route::post('page/builder/remove/{id}/component', 'BuilderController@deleteComponent')->middleware(['checkForDemoMode'])->name('builder.delete');
        Route::post('page/builder/update/{id}/all-component', 'BuilderController@updateAllComponents')->middleware(['checkForDemoMode'])->name('builder.updateAll');
        Route::get('ajax-search-resource/json', 'BuilderController@ajaxResourceFetch')->name('ajaxResourceSelect');
    });

    Route::prefix('vendor')->namespace('Modules\CMS\Http\Controllers\Vendor')->group(function () {
        Route::get('/homes', 'HomeController@index')->name('vendor.home');
        Route::get('/homes/edit/{slug}', 'HomeController@edit')->name('vendor.home.edit');
        Route::post('homes/update/{id}', 'HomeController@update')->name('vendor.home.update');
        Route::get('homes/create', 'HomeController@create')->name('vendor.home.create');
        Route::post('homes/store', 'HomeController@store')->name('vendor.home.store');
        Route::post('homes/delete/{id}', 'HomeController@delete')->name('vendor.home.delete');

        // Page builder
        Route::get('homes/builder/{slug}', 'BuilderController@edit')->name('vendor.builder.edit');
        Route::match(['get', 'post'], 'homes/builder/edit/{file}', 'BuilderController@editElement')->name('vendor.builder.form');
        Route::post('homes/builder/edit/{id}/component', 'BuilderController@updateComponent')->name('vendor.builder.update');
        Route::post('homes/builder/remove/{id}/component', 'BuilderController@deleteComponent')->middleware(['checkForDemoMode'])->name('vendor.builder.delete');
        Route::post('homes/builder/update/{id}/all-component', 'BuilderController@updateAllComponents')->middleware(['checkForDemoMode'])->name('vendor.builder.updateAll');
        Route::get('ajax-search-resource/json', 'BuilderController@ajaxResourceFetch')->name('vendor.ajaxResourceSelect');
    });
});

Route::group(['prefix' => 'api', 'namespace' => 'Modules\CMS\Http\Controllers\Api', 'middleware' => ['locale', 'api']], function () {
    // Slider
    Route::get('/sliders', 'SliderController@index');
});

Route::get('vendor/get-component-product', 'Modules\CMS\Http\Controllers\Vendor\BuilderController@getComponentProduct')->name('vendor.ajax-product');
