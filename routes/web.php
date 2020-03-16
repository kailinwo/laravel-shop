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
Route::get('products', 'ProductsController@index')->name('products.index');
//商品详情的页面，与 商品的我的收藏页面路由规则冲突，使用where（）搭配正则匹配即可解决此问题
Route::get('products/{product}', 'ProductsController@show')->name('products.show')->where(['product' => '[0-9]+']);
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

    //添加收藏
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    //我的收藏
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

    //添加购物车
    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

    //下订单
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    //订单列表
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    //订单详情
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    //订单支付[支付宝]
    Route::get('orders/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    //订单支付[微信]
    Route::get('orders/{order}/wechat', 'PaymentController@payByWechat')->name('payment.wechat');
    //支付宝的前端回调
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');

    //确认收货
    Route::post('orders/{order}/received','OrdersController@received')->name('orders.received');

    //评价
    Route::get('orders/{order}/review','OrdersController@review')->name('orders.review.show');
    //发送评价
    Route::post('orders/{order}/review','OrdersController@sendReview')->name('orders.review.store');
    //申请退款
    Route::post('orders/{order}/apply_refund','OrdersController@applyRefund')->name('orders.apply_refund');
    //优惠券查询
    Route::get('coupon_codes/{code}','CouponCodesController@show')->name('coupon_codes.show');
});
//支付宝的服务端回调，没有认证信息，所以不能放在需要认证的路由组里；
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
//微信的服务端回调
Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');
//微信的退款
Route::post('payment/wechat/refund_notify', 'PaymentController@wechatRefundNotify')->name('payment.wechat.refund_notify');

