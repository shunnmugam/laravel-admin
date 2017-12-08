<?php

return[

    /*
     * main configurations
     */

    'path' => 'cms',

    /*
     * modules configuration
     */
    'module' => [
        /*
         * module path
         */
        'path' => 'local',
        /*
         * configuration file name
         */
        'configuration' => 'module.json',
        /*
         *core path
         */
        'core_path' => 'core',
        /*
         * local path
         */
        'local_path' => 'local',
    ],
    /*
     * Theme
     */
    'theme' => [
        'active' => 'theme2',
        /*
         * fall back theme
         */
        'fall_back' => 'theme1'
    ],
    /*
     * skin
     */
    'skin' => [
        'path' => public_path('skin')
    ]
];
