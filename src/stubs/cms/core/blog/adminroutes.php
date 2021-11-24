<?php

use Illuminate\Support\Facades\Route;

/*
 * blog
 */

Route::group(['prefix' => 'blogs'], function () {
    Route::get('/', function () {
        return redirect()->route('blog.index');
    });
    //get users list
    Route::post('data', 'BlogController@getData')->name('get_blog_data_from_admin');

    //bulk option
    Route::post('action/{action}', 'BlogController@statusChange')->name('blog_action_from_admin');

    Route::resource('blog', 'BlogController');
});
/*
 * blog category
 */
Route::group(['prefix' => 'blog-category'], function () {
    Route::get('/', function () {
        return redirect()->route('blog-category.index');
    });
    //get users list
    Route::post('data', 'BlogCategoryController@getData')->name('get_blog-category_data_from_admin');

    //bulk option
    Route::post('action/{action}', 'BlogCategoryController@statusChange')->name('blog-category_action_from_admin');

    Route::resource('blog-category', 'BlogCategoryController');
});
