<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //通过factory()方法生成100个用户
        factory(\App\Models\User::class,100)->create();
    }
}
