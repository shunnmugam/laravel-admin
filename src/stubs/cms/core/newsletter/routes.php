<?php
Route::post('add-subscriber','NewsletterController@storeFromSite');
Route::get('remove-subscriber','NewsletterController@removeFromSite')->name('remove_subscriber');