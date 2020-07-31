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

//Route::get('/usr/info','TestController@userinfo');


Route::get('/', function () {
    return view('welcome');
});



Route::get('/usr/info','TestController@userinfo');
Route::get('/usr/aes1','TestController@aes1');//对称加密

Route::get('/usr/aes2','TestController@aes2');//非对称加密
Route::post('/usr/aes3','TestController@aes3');//非对称加密

Route::get('/usr/sign1','TestController@sign1');//签名
Route::get('/usr/sign2','TestController@sign2');//签名
Route::get('/usr/test2','TestController@test2');//签名



Route::get('/login','LoginController@index');//登陆
Route::get('/register','LoginController@register');//注册


Route::get('/test/pay','AlipayController@testPay');
Route::get('/pay','AlipayController@pay');





