<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'feedbacks'], function () {
    Route::get('/', function () {
        return redirect()->route('feedback.index');
    });
    //get users list
    Route::post('data', 'FeedBackController@getData')->name('get_feedback_data_from_admin');

    //bulk option
    Route::post('action/{action}', 'FeedBackController@statusChange')->name('feedback_action_from_admin');

    Route::resource('feedback', 'FeedBackController');
});
