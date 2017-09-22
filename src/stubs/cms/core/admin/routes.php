<?php

Route::group(['prefix' => 'administrator','middleware' => ['web'],'namespace' => 'cms\core\admin\Controllers'], function()
{
    /*
     * backend login
     */
    Route::get('login','AdminAuth@login')->name('backendlogin');
    /*
     * do back end login
     */
    Route::post('dologin','AdminAuth@dologin')->name('dobackendlogin');
});

