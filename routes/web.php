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


Route::get('/', 'PagesController@root')->name('home');
//开启邮箱验证
Auth::routes(['verify' => true]);
//需要登录成功才能访问
Route::group(['middleware' => ['auth', 'verified']], function () {
    //地址列表；
    Route::get('user_address', 'UserAddressesController@index')->name('user_address.index');
    //新建地址页面;
    Route::get('user_address/create', 'UserAddressesController@create')->name('user_address.create');
    //保存地址
    Route::post('user_address', 'UserAddressesController@store')->name('user_address.store');
});

