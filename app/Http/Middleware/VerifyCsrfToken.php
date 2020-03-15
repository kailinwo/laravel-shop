<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //支付宝那边没有csrftoken需要忽略这个地址的csrf验证
        'payment/alipay/notify',
        //微信支付同理
        'payment/wechat/notify',
        //微信退款回调
        'payment/wechat/refund_notify',
    ];
}
