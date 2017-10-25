<?php
/*
 * return plugins array
 */
return [
    /*
     * Login and Register Popup plugin
     */
    "NewsLetter" => [

       "version" => "0.0.1",

        "action" => "\cms\core\\newsletter\Controllers\NewsletterController@Plugindisplay",

        "view"   => "newsletter::plugins.NewsLetter",

        "adminview" => "newsletter::plugins.admin.NewsLetter"
    ]
];