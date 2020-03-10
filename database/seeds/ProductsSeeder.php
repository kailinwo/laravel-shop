<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = factory(\App\Models\Product::class, 30)->create();
        foreach ($products as $product) {
            $skus = factory(\App\Models\ProductSku::class, 3)->create(['product_id' => $product->id]);
            //找出价格最低的sku价格
            $product->update(['price' => $skus->min('price')]);
        }
    }
}
