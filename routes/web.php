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


Route::redirect('/', '/products')->name('root');
Route::get('products','ProductsController@index')->name('products.index');
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
    //修改地址页面
    Route::get('user_address/{user_address}', 'UserAddressesController@edit')->name('user_address.edit');
    //保存修改地址
    Route::put('user_address/{user_address}', 'UserAddressesController@update')->name('user_address.update');
    //删除地址
    Route::delete('user_address/{user_address}', 'UserAddressesController@destroy')->name('user_address.delete');
});

