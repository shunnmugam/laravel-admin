<?php

namespace Ramesh\Cms\Facades;

use Illuminate\Support\Facades\Facade;

class Cms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Cms';
    }
}
