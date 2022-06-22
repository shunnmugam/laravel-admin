<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Cms;
use Illuminate\Support\Facades\File;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:cms-seed {--module=} {--class=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cms-module database seed';

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

        $module =  $this->option('module');

        $class =  $this->option('class');

        if ($module) {
            if ($class) {
                $this->call('db:seed', [
                    '--class' =>  Cms::getPath() . '\\' . $module . '\\Database\\seeds\\' . $class
                ]);
            } else {
                $module_path = base_path() . '/' . Cms::getPath() . '/' . Cms::getModulesPath() . '/' . Cms::getCurrentTheme() . '/' . $module . '/Database/seeds';
                $files = $this->getAllFileInFolder($module_path);
                foreach ($files as $file) {
                    $class_name = preg_replace('/\..+$/', '', $file);
                    $this->call('db:seed', [
                        '--class' =>  Cms::getPath() . '\\' .  $module . '\\Database\\seeds\\' . $class_name
                    ]);
                }
            }
        } else {
            $cms = Cms::allModulesPath(false);
            foreach ($cms as $module) {


                if ($class) {
                    if (File::exists(base_path() . '/' . $module . '/Database/seeds/' . $class . '.php')) {
                        $this->call('db:seed', [
                            '--class' => $module . '\\Database\\seeds\\' . $class
                        ]);
                    }
                } else {

                    $files = $this->getAllFileInFolder(base_path() . '/' . $module . '/Database/seeds');
                    //print_r($files);
                    foreach ($files as $file) {
                        $class_name = preg_replace('/\..+$/', '', $file);
                        $this->call('db:seed', [
                            '--class' =>  Cms::getPath() . '\\' .  $module . '\\Database\\seeds\\' . $class_name
                        ]);
                        //echo 'hai';
                    }
                }
            }
        }
        //echo 'success';
    }

    protected function getAllFileInFolder($folder)
    {
        $path = array();
        if (File::exists($folder)) {
            $files = File::allFiles($folder);
            foreach ($files as $file) {
                $path[] = $file->getfileName();
            }
        }
        return $path;
    }
}
