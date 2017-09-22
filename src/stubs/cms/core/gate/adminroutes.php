<?php
Route::group(['prefix'=>'roles-permissions'],function() {
    Route::get('/','RoleController@getRoles')->name('roles_index_from_admin');

    Route::post('save','RoleController@save')->name('save_roles_from_admin');
});