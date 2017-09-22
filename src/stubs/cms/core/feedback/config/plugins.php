<?php
/*
 * return plugins array
 */
return [
    /*
     * Login and Register Popup plugin
     */
    "Feedback" => [

       "version" => "0.0.1",

        "action" => "\cms\core\\feedback\Controllers\FeedbackPlugin@display",

        "view"   => "feedback::plugins.Feedback",

        "adminview" => "feedback::plugins.admin.Feedback"
    ]
];