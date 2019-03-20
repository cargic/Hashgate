<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group( [ 'domain'=>env('API_DOMAIN'),'namespace'=>'Api' ], function () {

    Route::post('send/verify/code', 'LoginController@sendVerifyCode');

    Route::post('login', 'LoginController@index');

    Route::group(['middleware' => 'auth:api'], function (){

        Route::get('user', 'UserController@index');

        Route::post('modify/phone','UserController@modifyPhone');
        Route::post('modify/avatar','UserController@modifyAvatar');
        Route::post('modify/email','UserController@modifyEmail');
        Route::post('modify/email/notify','UserController@modifyEmailNotify');
        Route::post('modify/name','UserController@modifyName');
        Route::post('modify/address','UserController@modifyAddress');
        Route::post('modify/electricity/price','UserController@modifyElectricityPrice');
        Route::post('modify/electricity/loss','UserController@modifyElectricityLoss');
        Route::post('send/mail/verify/code', 'LoginController@mailVerifyCode');

        Route::get('mill/list','UserMillController@mills');
        Route::post('mill/create','UserMillController@createMill');
        Route::post('mill/modify','UserMillController@modifyMill');

    });

});
