<?php

namespace cms\core\configurations\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use Cms;

class ConfigurationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('configurations::admin.module',  'cms\core\configurations\Controllers\ConfigurationsController@getModuleList');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerViews();
        //$this->registerRoute();
        $this->registerAdminRoute();
    }
    /**
     * web route
     */
    public function registerRoute()
    {
        Route::prefix('')
            ->middleware(['web'])
            ->namespace('cms\core\configurations\Controllers')
            ->group(__DIR__ . '/../routes.php');
    }
    /**
     * admin route
     */
    public function registerAdminRoute()
    {

        Route::prefix('administrator')
            ->middleware(['web', 'Admin'])
            ->namespace('cms\core\configurations\Controllers')
            ->group(__DIR__ . '/../adminroutes.php');
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $theme = Cms::getCurrentTheme();

        $viewPath = resource_path('views/modules/configurations');

        //$sourcePath = __DIR__.'/../resources/views';
        $Path = __DIR__ . '/../resources/views';
        $sourcePath = base_path() . '/cms/local/' . $theme . '/configurations/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/configurations';
        }, [$Path]), [$sourcePath, $Path]), 'configurations');
    }
}
