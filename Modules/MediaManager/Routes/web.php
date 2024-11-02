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

Route::group(['namespace' => 'Modules\MediaManager\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::post('media-manager/file/store', 'MediaManagerController@store')->name('mediaManager.store');

    Route::prefix('admin')->group(function () {
        Route::get('uploaded-files/create', 'MediaManagerController@create')->name('mediaManager.create');
        Route::post('media-manager/files/upload', 'MediaManagerController@upload')->name('mediaManager.upload');
        Route::get('uploaded-files', 'MediaManagerController@uploadedFiles')->name('mediaManager.uploadedFiles');
        Route::get('sort-files', 'MediaManagerController@sortFiles')->name('mediaManager.sortFiles');
        Route::get('paginate-files', 'MediaManagerController@paginateFiles')->name('mediaManager.paginateFiles');
        Route::get('uploaded-files/download/{id}', 'MediaManagerController@download')->name('mediaManager.download');
        Route::post('paginate-data', 'MediaManagerController@paginateData')->name('mediaManager.paginateData');
        Route::post('delete-image', 'MediaManagerController@deleteImage')->middleware(['checkForDemoMode'])->name('mediaManager.delete');
        Route::post('/extension-store', 'MediaManagerController@storeExtension')->name('extension.store');
        Route::get('/get-extension-in-ajax', 'MediaManagerController@getExtensionAjaxQuery')->name('getExtensionAjax');
    });

    Route::name('vendor.')->prefix('vendor')->namespace('Vendor')->group(function () {
        Route::post('media-manager/files/upload', 'MediaManagerController@upload')->name('mediaManager.upload');
        Route::post('paginate-data', 'MediaManagerController@paginateData')->name('mediaManager.paginateData');
        Route::get('sort-files', 'MediaManagerController@sortFiles')->name('mediaManager.sortFiles');
    });
});
