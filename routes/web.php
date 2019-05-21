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

Route::get('/', function () {
    return view('welcome');
});
//对称加密
Route::get('/test','TestController@test');
Route::get('/caesar','TestController@caesar');
Route::get('/decaesar','TestController@decaesar');

Route::get('/a','TestController@aaa');
Route::get('/vvv','TestController@vvv');

//非对称加密
Route::get('/caesarTest','TestController@caesarTest');

//签名
Route::get('/sign','TestController@sign');

//测试 注册
Route::get('/user/reg','UserController@reg');
Route::post('/user/regdo','UserController@regdo');
Route::get('/user/login','UserController@login');   //登录页面
Route::post('/user/logindo','UserController@logindo');  //登录执行
Route::get('/user/my','UserController@my');  //登录执行



Route::get('/test/a','TestController@a');  //登录执行


Route::get('/firm/reg','FirmController@reg');       //注册页面
Route::post('/firm/regdo','FirmController@regdo');  //执行注册
Route::get('/firm/my','FirmController@my');         //个人中心

//接口
Route::get('/firm/token','FirmController@getToken');    //获取token
Route::get('/firm/userip','FirmController@userip')->middleware('CheckLogin');   //获取ip
Route::get('/firm/ua','FirmController@ua')->middleware('CheckLogin');       //获取UA
Route::get('/firm/user','FirmController@userInfo')->middleware('CheckLogin');   //获取用户信息
Route::post('/firm/verify','FirmController@verify');













Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
