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

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Blog\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    // Category
    Route::get('blog/category/list', 'BlogCategoryController@index')->name('blog.category.index');
    Route::post('blog/category/store', 'BlogCategoryController@store')->name('blog.category.store');
    Route::post('blog/category/update', 'BlogCategoryController@update')->name('blog.category.update');
    Route::post('blog/category/delete/{id}', 'BlogCategoryController@delete')->middleware(['checkForDemoMode'])->name('blog.category.delete');
    // Blog
    Route::get('blogs', 'BlogController@index')->name('blog.index');
    Route::get('blog/create', 'BlogController@create')->name('blog.create');
    Route::post('blog/store', 'BlogController@store')->name('blog.store');
    Route::get('blog/edit/{id}', 'BlogController@edit')->name('blog.edit');
    Route::post('blog/update/{id}', 'BlogController@update')->name('blog.update');
    Route::post('blog/delete/{id}', 'BlogController@delete')->middleware(['checkForDemoMode'])->name('blog.delete');
});
