<?php
/*
 * get skin folder
 */
function skin($url=false)
{
    $skin =  asset('/'.Cms::getPath().'/'.'skin'.'/'.Cms::getCurrentTheme().'/');
    if($url)
        $skin.=$url;
    return $skin;
}