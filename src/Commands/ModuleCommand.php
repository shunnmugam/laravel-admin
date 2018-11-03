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
    protected $signature = 'make:cms-module {module-name} {--c|crud}';

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
            'module-name' => $this->module_name,
            '--crud' => $this->option('crud')
        ]);

        $this->call('make:cms-controller', [
            'controller-name' => ucfirst($this->module_name).'Controller',
            'module-name' => $this->module_name,
            '--resource' => 'default',
            '--crud' => $this->option('crud')
        ]);

        if($this->option('crud')) {
            $this->call('make:cms-crudroutes',[
                'module-name' => $this->module_name
            ]);

            $this->call('make:cms-crudviews',[
                'module-name' => $this->module_name
            ]);

            $this->call('make:cms-migration',[
                'name' => 'create_'.$this->module_name.'_table',
                'module-name' => $this->module_name,
                '--create' => $this->module_name
            ]);

            $this->call('make:cms-model',[
                'model-name' => ucfirst($this->module_name)."Model",
                'module-name' => $this->module_name,
                '--table' => $this->module_name
            ]);
        }

        $this->info('module created :) ');
    }
}
