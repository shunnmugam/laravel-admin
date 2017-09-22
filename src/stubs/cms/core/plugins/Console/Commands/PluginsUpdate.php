<?php

namespace cms\core\plugins\Console\Commands;

use Illuminate\Console\Command;

use Plugins;

class PluginsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:cms-plugins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cms Plugins updating command';

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
        Plugins::registerPlugins();
    }
}
