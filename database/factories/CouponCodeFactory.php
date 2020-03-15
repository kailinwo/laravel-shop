<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CouponCode;
use Faker\Generator as Faker;

$factory->define(CouponCode::class, function (Faker $faker) {
    //首先取出随机的类型
    $type = $faker->randomElement(array_keys(CouponCode::$typeMap));
    // 根据取得的类型生成对应折扣
    $value = $type === CouponCode::TYPE_FIXED ? random_int(1,200) : random_int(1,50);

    //如果是固定金额那么至少最低消费金额要大于 它自己 0.01 元
    if($type === CouponCode::TYPE_FIXED){
        $minAmount = $value + 0.01;
    }else{
// 如果是百分比折扣，有 50% 概率不需要最低订单金额
        if (random_int(0, 100) < 50) {
            $minAmount = 0;
        } else {
            $minAmount = random_int(100, 1000);
        }
    }
    return [
        'name' => join(' ',$faker->words),//随机生成文字
        'code' => CouponCode::findAvailableCode(),
        'type'       => $type,
        'value'      => $value,
        'total'      => 1000,
        'used'       => 0,
        'min_amount' => $minAmount,
        'not_before' => null,
        'not_after'  => null,
        'enabled'    => true,

    ];
});
