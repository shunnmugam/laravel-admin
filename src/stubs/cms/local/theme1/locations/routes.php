<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'locations'], function () {
    Route::get('get-states/{country_id}', 'StateController@getStates');
});
