<?php

Route::group([], function() {
    /*
     * backend dashboard
     */
    Route::get('/', 'AdminAuth@dashboard')->name('backenddashboard');

    Route::get('logout','AdminAuth@logout')->name('log_out_from_admin');
});



