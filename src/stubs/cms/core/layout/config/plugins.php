<?php
/*
 * return plugins array
 */
return [
    /*
     * Login and Register Popup plugin
     */
	"Slider" => [

        "version" => "0.0.1",

        "action" => "\cms\core\layout\Controllers\SliderPlugin@display", //collecting datas

        "view"   => "layout::plugins.site.slider", //front view path

        "adminview" => "layout::plugins.admin.slider" //backend view path
    ]

];