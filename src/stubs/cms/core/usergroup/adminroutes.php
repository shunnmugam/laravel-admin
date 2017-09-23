<?php
/**
 * Created Ramesh.
 * User: Justin Camoens
 * Date: 9/7/2017
 * Time: 2:43 PM
 */

Route::group(['prefix'=>'usergroups'],function() {
    Route::get('/',function(){
        return redirect()->route('usergroup.index');
    });
    //get users list
    Route::post('data','UserGroupController@getData')->name('get_user_group_data_from_admin');

    //bulk option
    Route::post('action/{action}','UserGroupController@statusChange')->name('user_group_action_from_admin');

    Route::resource('usergroup', 'UserGroupController');
});