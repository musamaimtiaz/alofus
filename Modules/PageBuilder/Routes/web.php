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

use Modules\PageBuilder\Http\Controllers\PageBuilderController;

Route::prefix('pagebuilder')->as('pb.')->middleware(['auth', 'locale', 'web'])->group(function () {
    Route::get('/editpage/{slug}', [PageBuilderController::class, 'index'])->name('edit');
    Route::match(['get', 'post'], '/save/{slug}', [PageBuilderController::class, 'store'])->name('store');
    Route::post('/store-image', [PageBuilderController::class, 'storeImage'])->name('store-image');
});
