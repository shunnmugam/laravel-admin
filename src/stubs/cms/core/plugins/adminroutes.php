<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'plugins'], function () {
    Route::get('/', function () {
        return redirect()->route('plugin.index');
    });
    //get users list
    Route::post('data', 'PluginsController@getData')->name('get_plugins_data_from_admin');

    //bulk option
    Route::post('action/{action}', 'PluginsController@statusChange')->name('plugins_action_from_admin');

    Route::resource('plugin', 'PluginsController');
});
