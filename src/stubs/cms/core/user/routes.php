<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {
    /*
     * do register from front end using ajax
     */
    Route::post('doajaxregister', 'UserController@ajaxRegister')->name('do_ajax_register');
    /*
     * do login from front end using ajax
     */
    Route::post('doajaxlogin', 'UserController@ajaxLogin')->name('do_ajax_login');
    /*
     * do register from front end
     */
    Route::post('doregister', 'UserController@register')->name('do_register');
    /*
     * do login from front end
     */
    Route::post('dologin', 'UserController@login')->name('do_login');
    /*
     * activate user from mail
     */
    Route::get('useractivate/{token}', 'UserController@activate')->name('user_activate_from_mail');
    /*
     * Forget password
     */
    Route::post('forgetpassword', 'UserController@forgetPassword')->name('forget_password');
    /*
     * verify Forget password token from mail
     */
    Route::get('verifyforgetpassword/{token}', 'UserController@verifyForgetPassword')->name('verify_forget_password_from_mail');
    /*
     * do  change password token from mail
     */
    Route::post('dochangepassword', 'UserController@dochangePassword')->name('do_change_password');
    /*
     * login page
     */
    Route::get('login', function () {
        if (User::isLogin())
            return redirect()->route('my_account');
        return view('user::site.login');
    })->name('login');
    /*
     * Register page
     */
    Route::get('register', function () {
        if (User::isLogin())
            return redirect()->route('my_account');
        return view('user::site.login');
    })->name('register');
    /*
     * user group redirect
     */
    Route::get('/', function () {
        return redirect()->route('my_account');
    });
    /*
     * do log out
     */
    Route::get('logout', 'UserController@logout')->name('logout');

    Route::group(['middleware' => ['UserAuth']], function () {
        /*
         * my account page
         */
        Route::get('my-account', 'UserController@account')->name('my_account');
        /*
         * update account
         */
        Route::post('update-account', 'UserController@updateAccount')->name('update_account');
    });
});
