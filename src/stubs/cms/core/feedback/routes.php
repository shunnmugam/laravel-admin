<?php

use Illuminate\Support\Facades\Route;

Route::post('dofeedback', 'FeedBackController@dofeedback')->name('do_feedback');
