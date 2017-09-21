<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Ramesh\Cms\Generators\FileGenerator;
use Cms;
class MakeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-notification {notification-name} {module-name} {--markdown=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Module Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module_name =  $this->argument('module-name');
        $notification_name =  $this->argument('notification-name');

        $FileGenerator = new FileGenerator;
        $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme())
            ->setClass($notification_name)
            ->setModule($module_name)
            ->MakeNotification($this->option('markdown'))
            ->create();
    }
}
