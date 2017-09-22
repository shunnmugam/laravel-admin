<?php
namespace cms\core\gate\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Cms;

class CGateServiceProvider extends ServiceProvider
{
    /*
     * artisan command
     */
    protected $commands = [
        'cms\core\role\Console\Commands\RoleUpdate'
    ];
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

        Gate::define('createhgfh', function ($module_namaenb) {
            echo $module_namaenb;
            return true;
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerViews();
        //$this->registerMiddleware();
        $this->registerAdminRoute();
       // $this->registerCommand();
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
            ->namespace('cms\core\gate\Controllers')
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

        $viewPath = resource_path('views/modules/gate');

        //$sourcePath = __DIR__.'/../resources/views';
        $Path = __DIR__.'/../resources/views';
        $sourcePath = base_path().'/cms/local/'.$theme.'/user/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/gate';
        }, [$Path]), [$sourcePath,$Path]), 'gate');
    }
    /*
     * register commands
     */
    protected function registerCommand()
    {
        $this->commands($this->commands);
    }
    /*
     * register middleware
     */
    public function registerMiddleware()
    {
        app('router')->aliasMiddleware('Role', \cms\core\role\Middleware\RoleCheck::class);
    }

}
