<?php

namespace App\Providers;

use Nwidart\Modules\Module;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $isConsole;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $allowUrls = [
            'install/database',
            'install/seedmigrate',
            'system-update',
            'reset-data',
            'is_upgrade',
            'upgrade-retry',
        ];

        $this->isConsole = $this->app->runningInConsole() || collect($allowUrls)->contains(function ($urlSegment) {
            return str_contains(url()->full(), $urlSegment);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->app['modules']->allEnabled() as $module) {
            $this->loadViews($module);
            $this->loadTranslations($module);

            if ($this->isConsole) {
                $this->loadMigrations($module);
                $this->loadModelFactories($module);
            }
        }
    }

    /**
     * Load views for the given module.
     *
     * @return void
     */
    private function loadViews(Module $module)
    {
        if ($this->isConsole) {
            $viewPath = resource_path('views/modules/' . $module->getLowerName());

            $sourcePath = module_path($module->getName(), 'Resources/views');

            $this->publishes([
                $sourcePath => $viewPath,
            ], ['views', $module->getLowerName() . '-module-views']);

            $this->loadViewsFrom(array_merge($this->getPublishableViewPaths($module), [$sourcePath]), $module->getLowerName());
        } else {
            $this->loadViewsFrom(module_path($module->getName(), 'Resources/views'), $module->getLowerName());
        }
    }

    /**
     * Load translations for the given module.
     *
     * @return void
     */
    private function loadTranslations(Module $module)
    {
        $langPath = resource_path('lang/modules/' . $module->getLowerName());

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $module->getLowerName());
        } else {
            $this->loadTranslationsFrom(module_path($module->getName(), 'Resources/lang'), $module->getLowerName());
        }

        $this->loadJsonTranslationsFrom(module_path($module->getName(), 'Resources/lang'), $module->getLowerName());
    }

    /**
     * Load migrations for the given module.
     *
     * @return void
     */
    private function loadConfigs(Module $module)
    {
        $this->publishes([
            module_path($module->getName(), 'Config/config.php') => config_path($module->getLowerName() . '.php'),
        ], $module->getLowerName());

        $this->mergeConfigFrom(
            module_path($module->getName(), 'Config/config.php'),
            $module->getLowerName()
        );
    }

    /**
     * Load migrations for the given module.
     *
     * @return void
     */
    private function loadMigrations(Module $module)
    {
        $this->loadMigrationsFrom("{$module->getPath()}/Database/Migrations");
    }

    /**
     * Load model factories for the given module.
     *
     * @return void
     */
    private function loadModelFactories(Module $module)
    {
        $path = "{$module->getPath()}/Database/Factories";
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(Module $module): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $module->getLowerName())) {
                $paths[] = $path . '/modules/' . $module->getLowerName();
            }
        }

        return $paths;
    }
}
