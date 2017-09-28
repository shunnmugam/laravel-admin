<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Ramesh\Cms\Generators\FileGenerator;
use Cms;
class ModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-module {module-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Cms modules';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    /*
     * module name
     */
    private $module_name;
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
        $this->module_name =  $this->argument('module-name');
        $FileGenerator = new FileGenerator;
        //genrate module.json
        $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme())
            ->setModule($this->module_name)
            ->makeModuleJson()
            ->create();
        $this->info('module.json created');
        //genrate composer.json
        $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme())
            ->setModule($this->module_name)
            ->makeModuleComposer()
            ->create();
        $this->info('composer.json created');

        $this->call('make:cms-provider', [
            'name' => ucfirst($this->module_name).'ServiceProvider',
            'module-name' => $this->module_name
        ]);

        $this->call('make:cms-controller', [
            'controller-name' => ucfirst($this->module_name).'Controller',
            'module-name' => $this->module_name,
            '--resource' => 'default'
        ]);

        $this->info('module created :) ');
    }
}
