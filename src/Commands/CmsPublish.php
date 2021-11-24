<?php

namespace Ramesh\Cms\Commands;

use Illuminate\Console\Command;

class CmsPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cms';

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
        //$obj = new CmsServiceProvider(\Illuminate\Support\Facades\App::class);
        //$obj->boot();
    }
}
