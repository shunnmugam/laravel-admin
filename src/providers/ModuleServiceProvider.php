<?php

namespace Ramesh\Cms\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;


use Unisharp\Laravelfilemanager\LaravelFilemanagerServiceProvider;
use Intervention\Image\ImageServiceProvider;

use Cms;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLibrary();

        if(!config('cms') || config('cms')=='')
        {
            //first time
        }
        else{
            $this->registerNamespace();

            $this->registerComposerAutoload();
            $this->registerHelpers();
        }

    }
    /*
     * register module providers
     */
    protected function registerProviders()
    {
        $res = Cms::allModuleProvider();
        //print_r($res);exit;
        $this->app->register('cms\tablebooking\Providers\TablebookingServiceProvider');
        foreach ($res as $key => $provider) {
            $this->app->register($provider);
        }
    }
    /*
     * register composer
     */
    protected function registerComposerAutoload()
    {

        $loader = require base_path() . '/vendor/autoload.php';
        $composers = Cms::allModulesComposer();
        foreach ($composers as $composer) {
            foreach($composer['autoload'] as $autoload) {
                foreach ($autoload as $key => $value)
                    $loader->setPsr4($key,base_path().DIRECTORY_SEPARATOR.$value);
            }
        }


    }
    protected function registerNamespace()
    {
        $modules = Cms::allModules();
        $loader = require base_path() . '/vendor/autoload.php';
        foreach($modules as $module)
        {
            if($module['type']=='local')
            {
                $loader->setPsr4('cms\\'.$module['name'].'\\',$module['path']);
            }
        }

        $this->registerProviders();
       // exit;
    }
    /*
     * Register Helpers
     */
    protected function registerHelpers()
    {

        foreach(Cms::allModulesHelpers() as $aliaas => $value) {
            $this->app->booting(function () use($aliaas,$value) {
                $loader = AliasLoader::getInstance();
                $loader->alias($aliaas, $value);
            });
        }
    }

    /*
     * register third party librarys
     */
    protected function registerLibrary()
    {
        $this->app->register(\Unisharp\Laravelfilemanager\LaravelFilemanagerServiceProvider::class);
        $this->app->register(\Intervention\Image\ImageServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Image', \Intervention\Image\Facades\Image::class);

    }
}
