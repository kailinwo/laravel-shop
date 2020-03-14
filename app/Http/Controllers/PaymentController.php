<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Order;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //支付宝支付
    public function payByAlipay(Order $order, Request $request)
    {
        //判断当前订单是否属于当前用户；
        $this->authorize('own', $order);
        //订单已经支付或者已关闭
        if ($order->paid_at || $order->closed) {
            throw new InvalidRequestException("订单状态不正确");
        }

        //调用支付宝的网页支付
        return app('alipay')->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount,
            'subject' => '支付 Kara Shop的订单：' . $order->no, //订单标题
        ]);
    }

    //支付包的前端回调
    public function alipayReturn()
    {
        try {
            app('alipay')->verify();
        } catch (\Exception $e) {
            return view('pages.error', ['msg' => '数据不正确']);
        }
        return view('pages.success', ['msg' => '付款成功']);
    }

    //支付宝的服务端回调
    public function alipayNotify()
    {
        $data = app('alipay')->verify();
        // 如果订单状态不是成功或者结束，则不走后续的逻辑
        // 所有交易状态：https://docs.open.alipay.com/59/103672
        if (!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            return app('alipay')->success();
        }
        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
        $order = Order::where('no', $data->out_trade_no)->first();
        if (!$order) {
            return 'fail';
        }
        //如果这笔订单的状态是已经支付的
        if ($order->paid_at) {
            return app('alipay')->success();
        }
        $order->update([
            'paid_at' => Carbon::now(),
            'payment_method' => 'alipay', //支付方式
            'payment_no' => $data->trade_no,
        ]);
        return app('alipay')->success();
    }


    //微信支付
    public function payByWechat(Order $order,Request $request)
    {
        //订单权限验证
        $this->authorize('own',$order);
        // 校验订单状态
        if ($order->paid_at || $order->closed) {
            throw new InvalidRequestException('订单状态不正确');
        }
        // scan 方法为拉起微信扫码支付
        $wechatOrder = app('wechat_pay')->scan([
            'out_trade_no' => $order->no,  // 商户订单流水号，与支付宝 out_trade_no 一样
            'total_fee' => $order->total_amount * 100, // 与支付宝不同，微信支付的金额单位是分。
            'body'      => '支付 Kara Shop 的订单：'.$order->no, // 订单描述
        ]);
        //把要转换的字符串作为qrCode的构造函数；
        $qrCode = new QrCode($wechatOrder->code_url);
        //将生成好的二维码图片数据以字符串的形式输出，并带上响应的类型；
        return response($qrCode->writeString(),200,['Content-type'=>$qrCode->getContentType()]);
    }

    //微信支付的回调
    public function wechatNotify()
    {
        //校验参数是否正确
        $data = app('wechat_pay')->verify();
        //找到对应的订单
        $order = Order::where('no',$data->out_trade_no)->first();
        if(!$order){
            return 'fail';
        }
        //订单已经支付
        if($order->paid_at){
            //告知订单已经处理
            return app('wechat_pay')->success();
        }
        //将订单标记为已经支付
        $order->update([
            'paid_at'=>Carbon::now(),
            'payment_method'=>'wechat',
            'payment_no'=>$data->transaction_id,
        ]);
    }
}
