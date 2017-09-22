<?php
/*
 * return roles array
 */
return [
    "login" => [
        "route" => "administrator/roles",
        "default" => 0,
        "type" => "after",
        "action" => "cms\core\user\Controllers\UserController",
        "strict" => true
    ]
];