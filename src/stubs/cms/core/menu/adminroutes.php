<?php
Route::group(['prefix'=>'menus'],function() {
    Route::get('/',function(){
        return redirect()->route('menu.index');
    });
    //get menu list
    Route::post('data','MenuController@getData')->name('get_menu_data_from_admin');

    //bulk option
    Route::post('action/{action}','MenuController@statusChange')->name('menu_action_from_admin');

    Route::get('getmenuurl','MenuController@getMenuUrl')->name('get_menu_url_from_admin');

    Route::resource('menu', 'MenuController');




});

Route::get('menu', 'WmenuController@wmenuindex')->name('wmenuindex');
Route::post('addcustommenu', 'WmenuController@addcustommenu')->name('addcustommenu');
Route::post('addcustompagemenu','WmenuController@addcustompagemenu')->name('addcustompagemenu');
Route::post('deleteitemmenu', 'WmenuController@deleteitemmenu')->name('deleteitemmenu');
Route::post('deletemenug', 'WmenuController@deletemenug')->name('deletemenug');
Route::post('createnewmenu', 'WmenuController@createnewmenu')->name('createnewmenu');
Route::post('generatemenucontrol', 'WmenuController@generatemenucontrol')->name('generatemenucontrol');
Route::post('updateitem', 'WmenuController@updateitem')->name('updateitem');