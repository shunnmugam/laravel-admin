<?php
/*
 * get skin folder
 */
function skin($url=false)
{
    $skin =  asset('/'.'skin'.'/'.Cms::getCurrentTheme().'/');


    //if(!File::exists(asset('skin'.'/'.Cms::getCurrentTheme()))) {
       // $skin =  asset('/'.'skin'.'/theme1/');
    //}

    if($url)
        $skin.=$url;
    return $skin;
}
/*
* get theme path
*/
function theme_path()
{
    return base_path().'/cms/local/'.Cms::getCurrentTheme().'/';
}