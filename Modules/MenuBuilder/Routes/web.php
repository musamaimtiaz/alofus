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
Route::group(['prefix' => 'admin', 'namespace' => 'Modules\MenuBuilder\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    Route::get('/menu-builder', 'MenuBuilderController@index')->name('menu.index');
    Route::post('create-newmenu', 'MenuController@createNewMenu')->name('menu.create');
    Route::post('delete-menu', 'MenuController@delete')->middleware(['checkForDemoMode'])->name('menu.delete');
    Route::post('add-custom-menu', 'MenuController@addCustomMenu')->middleware(['checkForDemoMode'])->name('menu.custom');
    Route::post('update-item', 'MenuController@update')->middleware(['checkForDemoMode'])->name('menu.update');
    Route::post('generate-menu-control', 'MenuController@generateMenuControl')->name('menu.control');
    Route::post('delete-menu-item', 'MenuController@deleteMenu')->middleware(['checkForDemoMode'])->name('menu.item.delete');
});
