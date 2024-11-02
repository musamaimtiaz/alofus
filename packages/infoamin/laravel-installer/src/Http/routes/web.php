<?php

Route::group(['namespace' => 'Infoamin\Installer\Http\Controllers'], function () {
    Route::group(['prefix' => 'install', 'middleware' => ['web', 'installed']], function () {
        Route::get('/', 'WelcomeController@welcome');
        Route::get('database', 'DatabaseController@create');
        Route::get('requirements', 'RequirementsController@requirements');
        Route::get('permissions', 'PermissionsController@checkPermissions');
        Route::get('seedmigrate/{type}', 'DatabaseController@seedMigrate');
        Route::match(['GET', 'POST'], 'verify-envato-purchase-code', 'PermissionsController@verifyPurchaseCode')
            ->name('purchase-code-check');
        Route::post('database', 'DatabaseController@store');
        Route::get('register', 'UserController@createUser');
        Route::post('register', 'UserController@storeUser');
        Route::get('finish', 'FinalController@finish');
    });

    Route::post('install/clear-cache', 'PermissionsController@clearCache');

});
