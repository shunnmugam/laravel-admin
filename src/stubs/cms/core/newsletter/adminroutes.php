<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'news-letter'], function () {


    //get subscribers list
    Route::post('data', 'NewsletterController@getData')->name('get_newsletter_subscribers_from_admin');

    //bulk option
    Route::post('action/{action}', 'NewsletterController@statusChange')->name('newsletter_subscribers_action_from_admin');

    //create mail
    Route::get('newsletter', 'NewsletterController@createMail')->name('newsletter_create_mail_from_admin');

    //create mail
    Route::post('send-newsletter', 'NewsletterController@sendMail')->name('newsletter_send_mail_from_admin');

    Route::resource('subscriber', 'NewsletterController');
});
