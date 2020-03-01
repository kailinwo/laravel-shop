<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'on_sale', 'image', 'price', 'rating', 'sold_count', 'review_count'
    ];

    protected $casts = [
        'on_sale' => 'boolean',
    ];

    //与商品表关联
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }
}
