<?php
namespace cms\core\page\helpers;

use cms\core\page\Models\PageModel;
class Page
{
    public static function get($name)
    {
        $data = PageModel::where('url','=',$name)->first();

        return $data;
    }
}