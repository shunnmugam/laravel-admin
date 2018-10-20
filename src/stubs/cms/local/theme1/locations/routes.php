<?php
Route::group(['prefix'=>'locations'],function(){
    Route::get('get-states/{country_id}','StateController@getStates');
});
