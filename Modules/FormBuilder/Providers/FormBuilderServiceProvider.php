<?php

namespace Modules\FormBuilder\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\FormBuilder\Http\Middleware\PublicFormAccess;

class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Route::aliasMiddleware('public-form-access', PublicFormAccess::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
