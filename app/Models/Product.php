<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    //图片地址的访问器
    public function getImageUrlAttribute()
    {
        if(Str::startsWith($this->attributes['image'],['http://','https://'])){
            return $this->attributes['image'];
        }
        return \Storage::disk('public')->url($this->attributes['image']);
    }
}
