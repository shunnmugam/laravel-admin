<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Ramesh\Cms\Generators\FileGenerator;
use Cms;
class MakeCrudViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'make:cms-model {model-name} {module-name} {--c|controller=} {--m|migration=} {--r|resource} {-mc} {-cm} {-mcr} {-crm}';

    protected $signature = 'make:cms-crudviews {module-name} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make crud routes';

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

        $FileGenerator = new FileGenerator;
        $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme())
            ->setModule($module_name)
            ->makeCrudViews()
            ->create();

        $this->info('crud views created');
    }
}
