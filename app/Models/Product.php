<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    const TYPE_NORMAL = 'normal';
    const TYPE_CROWDFUNDING = 'crowdfunding';
    public static $typeMap = [
        self::TYPE_NORMAL => '普通商品',
        self::TYPE_CROWDFUNDING => '众筹商品',
    ];
    protected $fillable = [
        'title', 'description', 'on_sale', 'image', 'price', 'rating', 'sold_count', 'review_count', 'type'
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
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }
        return \Storage::disk('public')->url($this->attributes['image']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //众筹商品关联
    public function crowdfunding()
    {
        return $this->hasOne(CrowdfundingProduct::class);
    }
}
