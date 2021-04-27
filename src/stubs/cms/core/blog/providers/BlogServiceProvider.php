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
    public function boot() {
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
    public function registerRoute() {

        Route::prefix('administrator')
            ->middleware(['web'])
            ->namespace('cms\core\blog\Controllers')
            ->group(__DIR__ . '/../routes.php');
    }
    /**
     * admin route
     */
    public function registerAdminRoute()
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
