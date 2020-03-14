<?php

namespace App\Http\Controllers;

use App\Events\OrderReviewed;
use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\SendReviewRequest;
use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['items.product', 'items.productSku'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('orders.index', ['orders' => $orders]);
    }

    public function store(OrderRequest $request, OrderService $orderService)
    {
        $user = $request->user();
        $address = UserAddress::find($request->input('address_id'));
        $remark = $request->input('remark');
        $items = $request->input('items');
        return $orderService->store($user, $address, $remark, $items);
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    public function received(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        //判断状态是否为已经发货
        if ($order->ship_status !== Order::SHIP_STATUS_DELIVERED) {
            throw new InvalidRequestException('发货状态不正确');
        }
        //更新状态为已收到
        $order->update([
            'ship_status' => Order::SHIP_STATUS_RECEIVED,
        ]);
        //返回原界面
        return $order;
    }

    public function review(Order $order)
    {
        $this->authorize('own', $order);
        //是否已经支付
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        //方式N+1 使用load
        return view('orders.review', ['order' => $order->load(['items.product', 'items.productSku'])]);
    }

    public function sendReview(Order $order, SendReviewRequest $request)
    {
        $this->authorize('own', $order);

        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        if ($order->reviewed) {
            throw new InvalidRequestException('该订单已经评价，不可重复提交');
        }
        $reviews = $request->input('reviews');
        //开启事务
        \DB::transaction(function () use ($reviews, $order) {
            //遍历用户提交的数据
            foreach ($reviews as $review) {
                $orderItem = $order->items()->find($review['id']);
                //保存评分和评价
                $orderItem->update([
                    'rating' => $review['rating'],
                    'review' => $review['review'],
                    'reviewed_at' => Carbon::now()
                ]);
            }
            //将订单标记为已评价
            $order->update(['reviewed' => true]);
            //评论之后就触发该商品的评论事件，重新计算商品的评分
            event(new OrderReviewed($order));
        });

        return redirect()->back();

    }
}
