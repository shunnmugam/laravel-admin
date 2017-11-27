<?php
/*
 * return plugins array
 */
return [
    /*
     * Login and Register Popup plugin
     */
    "SocialLinks" => [

       "version" => "0.0.1",

        "action" => "\cms\sociallinks\Controllers\SociallinksController@Plugindisplay",

        "view"   => "sociallinks::plugins.sociallinks",

        "adminview" => "sociallinks::plugins.admin.sociallinks"
    ]
];