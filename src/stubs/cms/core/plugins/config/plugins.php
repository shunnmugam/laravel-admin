<?php
/*
 * return plugins array
 */
return [
    /*
     * Login and Register Popup plugin
     */
    "LRpopup" => [

       "version" => "0.0.1",

        "action" => "\cms\core\plugins\Controllers\LRpopup@display",

        "view"   => "plugins::plugins.LRpopup",

        "adminview" => "plugins::plugins.admin.LRpopup"
    ]
];