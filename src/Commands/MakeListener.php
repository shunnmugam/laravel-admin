<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Ramesh\Cms\Generators\FileGenerator;
use Cms;
class MakeListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-listener {name} {module-name} {--event=}';

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
        $name =  $this->argument('name');
        $event = $this->option('event');

        if($event) {
            $FileGenerator = new FileGenerator;
            $FileGenerator
                ->setPath(base_path() . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . Cms::getModulesPath() . DIRECTORY_SEPARATOR . Cms::getCurrentTheme())
                ->setClass($name)
                ->setModule($module_name)
                ->setEvent($event)
                ->MakeListener()
                ->create();
        }
        else
            $this->error('Event is required');
    }
}
