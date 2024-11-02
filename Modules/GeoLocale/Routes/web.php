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

Route::group(['namespace' => 'Modules\GeoLocale\Http\Controllers', 'middleware' => ['locale', 'web']], function () {

    Route::group(['prefix' => 'admin'], function () {
        // GeoLocale
        Route::get('geolocale', 'GeoLocaleController@index')->name('geolocale.index');

        // Country
        Route::get('/countries', 'CountryController@index');
        Route::get('/countries/{ciso}', 'CountryController@show');
        Route::post('/country/store', 'CountryController@store')->middleware(['checkForDemoMode'])->name('country.store');
        Route::post('/country/update/{id}', 'CountryController@update')->middleware(['checkForDemoMode'])->name('country.update');
        Route::post('/country/delete/{id}', 'CountryController@destroy')->middleware(['checkForDemoMode'])->name('country.delete');

        Route::get('/country-search/{keyword}', 'CountryController@search');

        // State
        Route::get('/states', 'StateController@index');
        Route::get('/countries/{ciso}/states/{siso}', 'StateController@show');
        Route::get('/countries/{ciso}/states', 'StateController@getCountryStates');
        Route::post('/state/store', 'StateController@store')->middleware(['checkForDemoMode'])->name('state.store');
        Route::post('/state/update/{id}', 'StateController@update')->middleware(['checkForDemoMode'])->name('state.update');
        Route::post('/state/delete/{id}', 'StateController@destroy')->middleware(['checkForDemoMode'])->name('state.delete');

        Route::get('/state-search/{stateKeyword}/{countryCode?}', 'StateController@search');

        // City
        Route::get('/countries/{ciso}/cities', 'CityController@getCountryCities');
        Route::get('/countries/{ciso}/states/{siso}/cities', 'CityController@getStateCities');
        Route::post('/city/store', 'CityController@store')->middleware(['checkForDemoMode'])->name('city.store');
        Route::post('/city/update/{id}', 'CityController@update')->middleware(['checkForDemoMode'])->name('city.update');
        Route::post('/city/delete/{id}', 'CityController@destroy')->middleware(['checkForDemoMode'])->name('city.delete');
    });

    Route::group(['prefix' => 'geo-locale'], function () {
        // Country
        Route::get('/countries', 'CountryController@index');

        // State
        Route::get('/countries/{ciso}/states', 'StateController@getCountryStates');

        // City
        Route::get('/countries/{ciso}/states/{siso}/cities', 'CityController@getStateCities');

    });
});

Route::group(['prefix' => 'api', 'namespace' => 'Modules\GeoLocale\Http\Controllers\Api\User', 'middleware' => ['locale', 'api']], function () {

    // Country
    Route::get('/countries', 'CountryController@index');
    Route::get('/countries/{ciso}', 'CountryController@show');
    Route::post('/country/store', 'CountryController@store');
    Route::post('/country/update/{id}', 'CountryController@update');
    Route::delete('/country/delete/{id}', 'CountryController@destroy');

    // State
    Route::get('/states', 'StateController@index');
    Route::get('/countries/{ciso}/states/{siso}', 'StateController@show');
    Route::get('/countries/{ciso}/states', 'StateController@getCountryStates');
    Route::post('/state/store', 'StateController@store');
    Route::post('/state/update/{id}', 'StateController@update');
    Route::delete('/state/delete/{id}', 'StateController@destroy');

    // City
    Route::get('/countries/{ciso}/cities', 'CityController@getCountryCities');
    Route::get('/countries/{ciso}/states/{siso}/cities', 'CityController@getStateCities');
    Route::post('/city/store', 'CityController@store');
    Route::post('/city/update/{id}', 'CityController@update');
    Route::delete('/city/delete/{id}', 'CityController@destroy');
});
