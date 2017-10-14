<?php
namespace cms\core\blog\search;

use cms\core\blog\Models\BlogModel;

class Blog
{
    public $data;

    public $view = 'blog::site.search';

    function __construct()
    {
        $this->data =  BlogModel::searchable()->get();
    }
}