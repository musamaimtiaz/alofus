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

Route::group(['middleware' => ['isLoggedIn', 'web']], function () {
    Route::post('file/upload', 'FilesController@uploadEventAttachments');
    Route::post('file/remove', 'FilesController@deleteEventAttachment');
});

Route::group(['namespace' => 'Modules\Ticket\Http\Controllers', 'middleware' => ['auth', 'locale', 'web']], function () {
    Route::prefix('chat')->group(function () {
        Route::get('get-conversations/{thread_id}', 'ChatController@getConversations')->name('chat.getConversations');
        Route::get('send-product-details/{code}', 'ChatController@sendProductDetails')->name('chat.send-product-details');
        Route::get('initiate-chat/{code}', 'ChatController@initiateChatWithVendor')->name('chat.initiate-chat-with-vendor');
        Route::get('get-contact-list', 'ChatController@contact-list');
        Route::post('store-message', 'ChatController@storeMessage')->name('chat.store-message');
        Route::get('chat-vendor/{vendor_id}', 'ChatController@createChat')->name('chat.createChat');
        Route::get('inbox-refresh', 'ChatController@inboxRefresh')->name('chat.inbox-refresh');
    });

    Route::prefix('admin')->group(function () {
        // Category
        Route::get('ticket/list', 'TicketController@index')->name('admin.tickets');
        Route::post('ticket/store', 'TicketController@store')->name('admin.ticketStore');
        Route::get('ticket/reply/{id}', 'TicketController@view')->name('admin.threadReply');
        Route::post('ticket/reply/store', 'TicketController@replyStore')->name('admin.threadReply.store');
        Route::get('ticket/edit/{id}', 'TicketController@edit')->name('admin.threadEdit');
        Route::post('ticket/update', 'TicketController@update')->name('admin.threadUpdate');
        Route::get('ticket/pdf', 'TicketController@pdf')->name('admin.threadPdf');
        Route::get('ticket/csv', 'TicketController@csv')->name('admin.threadCsv');
        Route::post('ticket/delete', 'TicketController@delete')->middleware(['checkForDemoMode'])->name('admin.ticketDelete');
        Route::get('ticket/add', 'TicketController@add')->name('admin.threadAdd');
        Route::get('ticket/priority-status', 'TicketController@changePriority')->name('admin.changePriority');
        Route::post('ticket/change-assignee', 'TicketController@changeAssignee');
        Route::post('update/admin_reply', 'TicketController@updateReply');
        Route::post('ticket/change-status', 'TicketController@changeStatus');
        // Canned Message
        Route::get('canned/messages', 'CannedController@messages');
        Route::post('canned/messages/save', 'CannedController@storeMessage');
        Route::post('canned/search/{type}', 'CannedController@search');
        Route::post('canned/messages/edit', 'CannedController@editMessage');
        Route::post('canned/messages/update', 'CannedController@updateMessage');
        Route::post('canned/messages/delete/{id}', 'CannedController@destroyMessage');
        Route::get('canned/links', 'CannedController@links');
        Route::post('canned/links/save', 'CannedController@storeLink');
        Route::post('canned/links/edit', 'CannedController@editLink');
        Route::post('canned/links/update', 'CannedController@updateLink');
        Route::post('canned/links/delete/{id}', 'CannedController@destroyLink');
    });

    Route::group(['prefix' => 'vendor', 'namespace' => 'Vendor'], function () {
        // Vendor Ticket
        Route::get('ticket/list', 'TicketController@index')->name('vendor.threads');
        Route::get('ticket/add', 'TicketController@create')->name('vendor.threadAdd');
        Route::post('ticket/store', 'TicketController@store')->name('vendor.ticketStore');
        Route::get('ticket/reply/{id}', 'TicketController@view')->name('vendor.threadReply');
        Route::post('update/vednor-reply', 'TicketController@update')->name('vendor.updateReply');
        Route::post('ticket/reply/store', 'TicketController@replyStore')->name('vendor.threadReply.store');
        Route::post('ticket/change-status', 'TicketController@changeStatus');
        Route::get('ticket/pdf', 'TicketController@pdf')->name('vendor.threadPdf');
        Route::get('ticket/csv', 'TicketController@csv')->name('vendor.threadCsv');
        Route::get('files/download/{id}', 'FilesController@downloadAttachment');
    });
});

Route::group(['prefix' => 'api/user/chat', 'namespace' => 'Modules\Ticket\Http\Controllers\Api\User', 'middleware' => ['auth:api', 'locale', 'permission-api', 'api']], function () {
    Route::get('get-conversations/{thread_id}', 'ChatController@getConversations');
    Route::get('send-product-details/{code}', 'ChatController@sendProductDetails');
    Route::get('initiate-chat/{code}', 'ChatController@initiateChatWithVendor');
    Route::get('get-contact-list', 'ChatController@contact-list');
    Route::post('store-message', 'ChatController@storeMessage');
    Route::get('chat-vendor/{vendor_id}', 'ChatController@createChat');
    Route::get('inbox-refresh', 'ChatController@inboxRefresh');
});
