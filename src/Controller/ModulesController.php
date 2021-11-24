<?php

namespace Ramesh\Cms\Controller;

class ModulesController extends CmsController
{


    public function __construct()
    {
    }

    /*
     * get name of the module
     */
    public function getName()
    {
        return $this->name;
    }
}
