<?php

namespace Modules\MediaManager\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class MediaManagerServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
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
