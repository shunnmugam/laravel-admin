<?php
namespace cms\core\feedback\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

use Cms;

class FeedbackServiceProvider extends ServiceProvider
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
        $this->registerViews();
        $this->registerRoute();
        $this->registerAdminRoute();
    }

    /**
     * web route
     */
    public function registerRoute()
    {
        Route::prefix('')
            ->middleware(['web'])
            ->namespace('cms\core\feedback\Controllers')
            ->group(__DIR__ . '/../routes.php');
    }

    /**
     * admin route
     */
    public function registerAdminRoute()
    {
        Route::prefix('administrator')
            ->middleware(['web','Admin'])
            ->namespace('cms\core\feedback\Controllers')
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

        $viewPath = resource_path('views/modules/feedback');

        $Path = __DIR__.'/../resources/views';
        $sourcePath = base_path().'/cms/local/'.$theme.'/user/resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/feedback';
        }, [$Path]), [$sourcePath,$Path]), 'feedback');
    }


}
