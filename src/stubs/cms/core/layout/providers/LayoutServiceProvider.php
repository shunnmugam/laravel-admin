<?php
namespace cms\core\layout\providers;

use Illuminate\Support\ServiceProvider;

use Cms;
use Route;
use CmsMail;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        CmsMail::setMailConfig();
        /*
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($configPath, 'modules');
        $this->publishes([
            $configPath => config_path('modules.php'),
        ], 'config');
        */

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoot();
        $this->registerViews();
    }



    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $theme = Cms::getCurrentTheme();

        $viewPath = resource_path('views/modules/layout');

        //$sourcePath = __DIR__.'/../resources/views';
        $Path = __DIR__.'/../resources/views';
        $sourcePath = base_path().'/cms/local/'.$theme.'/layout/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/layout';
        }, [$Path]), [$sourcePath,$Path]), 'layout');
    }

    public function registerRoot()
    {

        Route::prefix('')
            ->middleware(['web'])
            ->namespace('cms\core\layout\Controllers')
            ->group(__DIR__ . '/../routes.php');


    }


}
