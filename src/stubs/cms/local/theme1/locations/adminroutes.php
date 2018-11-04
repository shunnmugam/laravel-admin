<?php
Route::group(['prefix'=>'locations'],function (){
    /*
     * import from csv
     */
    Route::get('country-import','CountryController@import')->name('country_import_from_admin');
    /*
     * do import
     */
    Route::post('do-country-import','CountryController@doImport')->name('doCountryImport');
    /*
     * get countries data
     */
    Route::post('get-country-data','CountryController@getData')->name('get_country_data_from_admin');
    /*
     * bulk action
     */
    Route::post('do-status-change-for-country/{action}','CountryController@statusChange')->name('country_action_from_admin');
    Route::resource('country','CountryController');

    /************* states ***************/
    /*
     * import from csv
     */
    Route::get('state-import','StateController@import')->name('state_import_from_admin');
    /*
     * do import
     */
    Route::post('do-state-import','StateController@doImport')->name('doStateImport');
    /*
     * get countries data
     */
    Route::post('get-state-data','StateController@getData')->name('get_state_data_from_admin');
    /*
     * bulk action
     */
    Route::post('do-status-change-for-state/{action}','StateController@statusChange')->name('state_action_from_admin');

    Route::resource('state','StateController');

    /************* cities ***************/
    /*
     * import from csv
     */
    Route::get('city-import','CityController@import')->name('city_import_from_admin');
    /*
     * do import
     */
    Route::post('do-city-import','CityController@doImport')->name('doCityImport');
    /*
     * get countries data
     */
    Route::post('get-city-data','CityController@getData')->name('get_city_data_from_admin');
    /*
     * bulk action
     */
    Route::post('do-status-change-for-city/{action}','CityController@statusChange')->name('city_action_from_admin');
    Route::resource('city','CityController');
});
