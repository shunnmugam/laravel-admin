<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;
use Cms;
class Migrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms-migrate {--module=} {--path=}';

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

        $module =  $this->option('module');

        $path =  $this->option('path');

        if($path) {
            $this->call('migrate', [
                '--path' => $path
            ]);
        }
        else if($module)
        {
           // echo '/'.Cms::getPath().'/'.Cms::getModulesPath().'/'.$module.'/Database/Migration';exit;
            $this->call('migrate', [
                '--path' => DIRECTORY_SEPARATOR.Cms::getPath().DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme().DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Migration'
            ]);
        }else
        {
            if(!\File::exists(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'migration')) {
                \File::makeDirectory(base_path().DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'migration' , 0777, true);

            }
            $cms = Cms::allModulesPath(false);
            foreach ($cms as $module)
            {
                if(\File::exists(base_path().$module.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR)) {
                    $files = \File::files(base_path().$module.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR);

                    foreach ($files as $file) {
                        \File::copy($file, base_path() . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1));
                    }
                }

            }

            $this->call('migrate', [
            '--path' => DIRECTORY_SEPARATOR.'cms'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'migration'
             ]);
        }

    }
}
