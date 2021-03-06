<?php

use Illuminate\Support\Facades\Route;

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

Route::get('a/demo', 'TestController@testIndex')->name('demo');

Route::group(['domain'=>env('ADMIN_DOMAIN'),'namespace'=>'Admin'],function () {

    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.logining');
    Route::get('logout', 'LoginController@logout')->name('admin.logout');

    Route::group(['middleware'=> 'auth.admin'],function () {

        Route::get('/', 'HomeController@index')->name('admin.home');
        Route::get('home', 'HomeController@index')->name('admin.home');

        Route::resource('millClasses','MillClassesController');
        Route::resource('mill','MillController');
    });

});
