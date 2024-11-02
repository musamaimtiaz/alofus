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

use Modules\FormBuilder\Http\Controllers\FormController;
use Modules\FormBuilder\Http\Controllers\KycController;
use Modules\FormBuilder\Http\Controllers\Vendor\KycController as UserKycController;
use Modules\FormBuilder\Http\Controllers\SubmissionController;

/**
 * Public form url
 */
Route::as('formbuilder::form.')->namespace('Modules\FormBuilder\Http\Controllers')->middleware(['locale', 'web'])->group(function () {
    Route::get('/form/feedback/{identifier}', 'RenderFormController@feedback')->name('feedback');
    Route::get('/form/{identifier}', 'RenderFormController@render')->name('render');
    Route::post('/form/{identifier}', 'RenderFormController@submit')->name('submit');
});

Route::prefix('admin')->as('formbuilder::')->namespace('Modules\FormBuilder\Http\Controllers')->middleware(['locale', 'auth', 'web'])->group(function () {

    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('forms/submissions', [SubmissionController::class, 'index'])->name('submissions.all');

    /**
     * My submission routes
     */
    Route::resource('/form/entry', 'MySubmissionController');

    /**
     * Form submission management routes
     */
    Route::prefix('/forms/{fid}')->group(function () {
        Route::resource('/submissions', 'SubmissionController');
    });

    /**
     * Kyc management routes
     */
    Route::name('kyc.')->prefix('forms')->middleware(['locale', 'auth', 'permission'])->group(function () {
        Route::get('kyc-form', [KycController::class, 'index'])->name('index');
        Route::get('kyc/edit/{form}', [KycController::class, 'edit'])->name('edit');
        Route::put('kyc/edit/{form}', [KycController::class, 'update'])->middleware(['checkForDemoMode'])->name('update');
        Route::get('kyc/submission/edit/{id}', [KycController::class, 'editSubmission'])->name('sub-edit');
        Route::put('kyc/submission/edit/{id}', [KycController::class, 'editSubmission'])->middleware(['checkForDemoMode'])->name('sub-update');
        Route::get('kyc/submission/{id}', [KycController::class, 'viewSubmission'])->name('sub-view');
        Route::delete('/kyc/delete/{id}', [KycController::class, 'submissionDelete'])->middleware(['checkForDemoMode'])->name('delete');
    });

    /**
     * Form management routes
     */
    Route::resource('/forms', 'FormController');
});

Route::prefix('vendor')->as('kyc.user.')->middleware(['locale', 'auth', 'permission', 'web'])->group(function () {
    Route::get('/kyc', [UserKycController::class, 'userKycForm'])->name('show');
    Route::post('/kyc/submit/{identifier}', [UserKycController::class, 'userKycSubmit'])->name('submit');
    Route::put('/kyc/update-submission/{id}', [UserKycController::class, 'userKycUpdateSubmission'])->name('update');
});
