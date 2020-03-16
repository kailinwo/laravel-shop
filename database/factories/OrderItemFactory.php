<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    //从数据库中随机取出取一条商品
    $product = \App\Models\Product::query()->where('on_sale', true)->inRandomOrder()->first();
    //从该商品的sku中随机取出一条
    $sku = $product->skus()->inRandomOrder()->first();

    return [
        'amount' => random_int(1, 5),
        'price' => $sku->price,
        'rating' => null,
        'review' => null,
        'reviewed_at' => null,
        'product_id' => $product->id,
        'product_sku_id' => $sku->id,
    ];
});
