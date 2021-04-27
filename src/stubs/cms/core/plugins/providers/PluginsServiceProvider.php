<?php
namespace cms\core\plugins\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use Cms;

class PluginsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected $commands = [
        "cms\core\plugins\Console\Commands\PluginsUpdate"
    ];
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
        $this->registerCommand();
        //$this->registerRoute();
        $this->registerAdminRoute();
    }

    public function registerRoute()
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


    }
    public function registerAdminRoute()
    {

        Route::prefix('administrator')
            ->middleware(['web','Admin'])
            ->namespace('cms\core\plugins\Controllers')
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

        $viewPath = resource_path('views/modules/plugins');

        //$sourcePath = __DIR__.'/../resources/views';
        $Path = __DIR__.'/../resources/views';
        $sourcePath = base_path().'/cms/local/'.$theme.'/plugins/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/plugins';
        }, [$Path]), [$sourcePath,$Path]), 'plugins');
    }
    /*
     * register commands
     */
    protected function registerCommand()
    {
        $this->commands($this->commands);
    }

}
