<?php

namespace cms\locations\Providers;

use Illuminate\Support\ServiceProvider;
use Route;
use Cms;
class LocationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->registerViews();
        $this->registerRoot();
        $this->registerAdminRoot();
        //$this->registerMiddleware();

    }

    public function registerRoot()
    {
        Route::prefix('')
            ->middleware(['web'])
            ->namespace('cms\locations\Controllers')
            ->group(__DIR__ . '/../routes.php');


    }
    public function registerAdminRoot()
    {

        Route::prefix('administrator')
            ->middleware(['web','Admin'])
            ->namespace('cms\locations\Controllers')
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

        $viewPath = resource_path('views/modules/locations');

        //$sourcePath = __DIR__.'/../resources/views';
        $Path = __DIR__.'/../resources/views';
        $sourcePath = base_path().'/cms/local/'.$theme.'/locations/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/locations';
        }, [$Path]), [$sourcePath,$Path]), 'locations');
    }
    /*
     * register middleware
     */
    public function registerMiddleware()
    {
        app('router')->aliasMiddleware('MiddleWareName', middlewarepath::class);
    }
    /*
     * register api's
     */
    public function registerApiRoot(){
        Route::group([
            'middleware' => ['SiteApi'],
            'namespace' => 'cms\locations\Controllers',
            'prefix' => 'api',
        ], function ($router) {
            require __DIR__ . '/../apiroutes.php';
        });
    }

}
