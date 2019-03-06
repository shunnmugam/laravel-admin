<?php

namespace Ramesh\Cms;

use Illuminate\Support\ServiceProvider;

use Ramesh\Cms\Controller\CmsController;
use Cms;
use Ramesh\Cms\providers\ModuleServiceProvider;
use Ramesh\Cms\providers\CommandProvider;
use Illuminate\Support\Facades\Schema;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $configPath = __DIR__ . '/config/lfm.php';
        $this->mergeConfigFrom($configPath, 'lfm');
        $this->publishes([
            $configPath => config_path('lfm.php'),
        ], 'config');
        $configPath = __DIR__ . '/config/cms.php';
        $this->mergeConfigFrom($configPath, 'cms');
        $this->publishes([
            $configPath => config_path('cms.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/stubs/skin' => public_path('skin'),
        ], 'public');
        $this->publishes([
            __DIR__.'/stubs/cms' => base_path('cms'),
        ], 'public');

        Schema::defaultStringLength(191);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Cms', function ($app) {
            return new CmsController();
        });
        $loader = require base_path() . '/vendor/autoload.php';
        $loader->setPsr4('cms\\core\\',base_path('cms/core'));
        //$loader->setPsr4('cms\\',base_path('cms/theme1'));


        $this->app->register(ModuleServiceProvider::class);
        $this->app->register(CommandProvider::class);

        include('Helper.php');

    }

}
