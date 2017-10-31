<?php
/*
 * get skin folder
 */
function skin($url=false)
{
    $skin =  asset('/'.'skin'.'/'.Cms::getCurrentTheme().'/');
    if($url)
        $skin.=$url;
    return $skin;
}
