<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Ramesh\Cms\Generators\FileGenerator;
use Cms;
class MakeController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-controller {controller-name} {module-name} {--r|resource} {--c|crud} {--model=} {--rn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Module Controller';

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
        $controller_name =  $this->argument('controller-name');

        $FileGenerator = new FileGenerator;
        $obj = $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme())
            ->setClass($controller_name);
        if($this->option('model')) {
            $obj = $obj->setModelName($this->option('model'));
        }
        if($this->option('rn')) {
            $obj = $obj->setResourceName($this->option('rn'));
        }
        $obj = $obj
            ->setModule($module_name)
            ->MakeController($this->option('resource'),$this->option('crud'))
            ->create();

        $this->info('controller created');
    }
}
