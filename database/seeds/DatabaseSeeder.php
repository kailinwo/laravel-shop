<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsersSeeder::class); //用户填充
        $this->call(UserAddressesSeeder::class); //用户地址填充
        $this->call(CategoriesSeeder::class); //分类列表填充
        $this->call(ProductsSeeder::class);//产品填充
        $this->call(CouponCodesSeeder::class);//优惠券填充
        $this->call(OrdersSeeder::class); //订单填充
    }
}
