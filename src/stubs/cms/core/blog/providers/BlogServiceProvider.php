<?php
namespace cms\core\blog\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use Cms;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
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
        $this->registerViews();
        //$this->registerRoot();
        $this->registerAdminRoot();
    }

    public function registerRoot()
    {
        /*

        $router = new Router;
        $router ->middleware('web')->group([
            'namespace' => 'cms\core\user\Controllers',
            'prefix' => ''
        ], function ($router) {
            // Ideally create a seperate apiroutes.php or something similar
            require __DIR__.'/../routes.php';
        });
        */

        Route::prefix('administrator')
            ->middleware(['web'])
            ->namespace('cms\core\blog\Controllers')
            ->group(__DIR__ . '/../routes.php');
    }
    public function registerAdminRoot()
    {

        Route::prefix('administrator')
            ->middleware(['web','Admin'])
            ->namespace('cms\core\blog\Controllers')
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

        $viewPath = resource_path('views/modules/blog');

        //$sourcePath = __DIR__.'/../resources/views';
        $Path = __DIR__.'/../resources/views';
        $sourcePath = base_path().'/cms/local/'.$theme.'/blog/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/blog';
        }, [$Path]), [$sourcePath,$Path]), 'blog');
    }


}
