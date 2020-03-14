<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProductSoldCount implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  OrderPaid $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        //从事件的对象中取出对应的订单；
        $order = $event->getOrder();
        //预加载商品数据
        $order->load(['items.product']);
        //循环遍历订单中的商品
        foreach ($order->items as $item) {
            $product = $item->product;
            //计算对应商品的销量
            $soldCount = OrderItem::query()
                ->where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->whereNotNull('paid_at');//关联的订单状态是否已经支付
                })->sum('amount');
            //更新商品销量
            $product->update([
                'sold_count' => $soldCount,
            ]);
        }
    }
}
