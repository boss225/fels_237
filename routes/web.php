<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('home');   
    Route::resource('profile', 'User\UserController', ['only' => ['show', 'edit', 'update']]);
    Route::get('word/list', 'User\WordController@showList');
    Route::post('word/filter', 'User\WordController@wordsFilter');

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::resource('categories', 'Admin\CategoryController', ['expect' => ['show', 'edit', 'create']]);
        Route::resource('accounts', 'Admin\AccountController', ['only' => ['index', 'destroy']]);
        Route::resource('word-list', 'Admin\WordController');
        Route::get('word-content', 'Admin\WordController@wordContent');        
    });
});
