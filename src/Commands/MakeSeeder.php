<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Ramesh\Cms\Generators\FileGenerator;
use Cms;
class MakeSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-seeder {class-name} {module-name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Module Seeder';

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
        $class_name =  $this->argument('class-name');

        $FileGenerator = new FileGenerator;
        $FileGenerator
            ->setPath(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme())
            ->setClass($class_name)
            ->setModule($module_name)
            ->MakeSeeder()
            ->create();
    }
}
