<?php
namespace cms\core\page\search;

use cms\core\page\Models\PageModel;

class Page
{
    public $data;

    public $view = 'page::site.search';

    function __construct()
    {
        $this->data =  PageModel::searchable()->get();
    }
}