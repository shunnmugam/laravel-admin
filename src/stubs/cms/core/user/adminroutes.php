<?php
Route::group(['prefix'=>'users'],function() {
    Route::get('/',function(){
        return redirect()->route('user.index');
    });
    //get users list
    Route::post('data','UserController@getData')->name('get_user_data_from_admin');

    //bulk option
    Route::post('action/{action}','UserController@statusChange')->name('user_action_from_admin');

    Route::resource('user', 'UserController');
});