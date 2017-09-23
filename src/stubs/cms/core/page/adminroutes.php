<?php
Route::group(['prefix'=>'pages'],function() {
    Route::get('/',function(){
        return redirect()->route('page.index');
    });
    //get users list
    Route::post('data','PageController@getData')->name('get_page_data_from_admin');

    //bulk option
    Route::post('action/{action}','PageController@statusChange')->name('page_action_from_admin');

    Route::resource('page', 'PageController');
});