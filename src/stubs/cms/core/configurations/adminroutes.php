<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'configurations'], function () {
    /*
     * module configurations
     */
    Route::get('module/{module_id}', 'ConfigurationsController@module')->name('admin_module_configuration');
    Route::post('moduleconfigsave', 'ConfigurationsController@moduleSave')->name('admin_module_configuration_save');
    /*
     * site configurations
     */
    Route::get('site', 'ConfigurationsController@site')->name('admin_site_configuration');
    Route::post('siteconfigsave', 'ConfigurationsController@sitesave')->name('admin_site_configuration_save');
    /*
     * mail configurations
     */
    Route::get('mail', 'ConfigurationsController@mail')->name('admin_mail_configuration');
    Route::post('mailconfigsave', 'ConfigurationsController@mailsave')->name('admin_mail_configuration_save');
});
