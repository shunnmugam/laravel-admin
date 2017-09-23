<?php
/*
 * return roles array
 */
namespace cms\core\menu\config;
//helpers
use Menu;
$menus = Menu::getAdminMenuOnly();
$array = array();
foreach ($menus as $menu)
{
    $array[$menu['name']."(Backend)"] = [
        "menu" => $menu['id'],
        "group" => "menu",
        "default" => 0,
        "type" => "before",
        "action" => "",
        "strict" => true
    ];
}
//print_r($array);exit;
return $array;