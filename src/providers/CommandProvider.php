<?php

namespace Ramesh\Cms\providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use Cms;

class CommandProvider extends ServiceProvider
{
    /*
     * Commands
     */
    protected $commands = [
        'Ramesh\Cms\Commands\ModuleCommand',
        'Ramesh\Cms\Commands\MakeController',
        'Ramesh\Cms\Commands\MakeModel',
        'Ramesh\Cms\Commands\MakeMigration',
        'Ramesh\Cms\Commands\MakeCommand',
        'Ramesh\Cms\Commands\MakeEvent',
        'Ramesh\Cms\Commands\MakeJob',
        'Ramesh\Cms\Commands\MakeListener',
        'Ramesh\Cms\Commands\MakeMail',
        'Ramesh\Cms\Commands\MakeMiddleware',
        'Ramesh\Cms\Commands\MakeNotification',
        'Ramesh\Cms\Commands\MakeProvider',
        'Ramesh\Cms\Commands\MakeSeeder',

        'Ramesh\Cms\Commands\Migrate',
        'Ramesh\Cms\Commands\Seed',
        'Ramesh\Cms\Commands\CmsPublish',
    ];


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
        $this->registerCommand();
    }
    /*
     * register commands
     */
    protected function registerCommand()
    {
        $this->commands($this->commands);
    }

}
