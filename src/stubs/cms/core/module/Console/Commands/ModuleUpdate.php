<?php

namespace cms\core\module\Console\Commands;

use Illuminate\Console\Command;
use Module;

class ModuleUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:cms-module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update modules';

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
        Module::registerModule();
    }
}
