<?php
Route::get('social-links','SociallinksController@index');
/*
*store function
*/
Route::post('save-social-links','SociallinksController@store');
/*
*update function
*/
Route::put('update-social-links','SociallinksController@update');