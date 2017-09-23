<?php
Route::group(['prefix'=>'page'],function(){
    Route::get('/{page}','PageController@show');
});