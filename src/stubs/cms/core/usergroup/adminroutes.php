<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'usergroups'], function () {
    Route::get('/', function () {
        return redirect()->route('usergroup.index');
    });
    //get users list
    Route::post('data', 'UserGroupController@getData')->name('get_user_group_data_from_admin');

    //bulk option
    Route::post('action/{action}', 'UserGroupController@statusChange')->name('user_group_action_from_admin');

    Route::resource('usergroup', 'UserGroupController');
});
