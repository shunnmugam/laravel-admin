<?php
Route::get('/',function(){
    return view('layout::site.welcome');
})->name('home');