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
Route::get('404', 'HomeController@error404'); 

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('home');  

    Route::group(['namespace' => 'User'], function () {
        Route::resource('profile', 'UserController', ['only' => ['show', 'edit', 'update']]);
        Route::post('search/user','UserController@searchUser');        
        Route::get('word/list', 'WordController@showList');
        Route::post('word/filter', 'WordController@wordsFilter');
        Route::get('word/category/{id}', 'WordController@wordsCategory');
        Route::post('word/category/{id}/filter', 'WordController@wordsCategoryFilter');
        Route::resource('lesson', 'LessonController', ['only' => ['index', 'store', 'show', 'update']]);
        Route::get('lesson/{id}/view', 'LessonController@view'); 
        Route::get('followers', 'UserController@followers'); 
        Route::get('following', 'UserController@following');
        Route::post('add/follow', 'UserController@addRelationship'); 
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::resource('categories', 'CategoryController', ['expect' => ['show', 'edit', 'create']]);
        Route::resource('accounts', 'AccountController', ['only' => ['index', 'destroy', 'edit', 'update']]);
        Route::resource('word-list', 'WordController');
        Route::resource('lesson', 'LessonController', ['only' => ['index', 'destroy']]);
        Route::get('word-content', 'WordController@wordContent');        
        Route::get('import-file', 'ExcelController@getImport');        
        Route::post('import-file', 'ExcelController@postImport');        
        Route::get('export', 'ExcelController@export');        
    });
});
