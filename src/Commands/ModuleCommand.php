<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
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
        $cms_path =  Cms::getPath();
        $this->call('make:controller', [
            'name' => '../../../'.$cms_path.'/local/Conrollers/Controller'
        ]);

    }
}
