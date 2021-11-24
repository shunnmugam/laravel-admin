<?php

use Illuminate\Support\Facades\Route;

Route::post('add-subscriber', 'NewsletterController@storeFromSite');
Route::get('remove-subscriber', 'NewsletterController@removeFromSite')->name('remove_subscriber');
