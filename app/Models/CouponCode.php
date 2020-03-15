<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CouponCode extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'value', 'total', 'used', 'min_amount', 'not_before', 'not_after', 'enabled'
    ];

    // 用常量的方式定义支持的优惠券类型
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    public static $typeMap = [
        self::TYPE_FIXED => '固定金额',
        self::TYPE_PERCENT => '比例',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
    // 指明这两个字段是日期类型
    protected $dates = [
        'not_before','not_after'
    ];

    protected $appends = ['description'];

    //生成优惠码
    public static function findAvailableCode($length = 16)
    {
        do{
            //生成指定长度的随机字符串，并转成大写
            $code = strtoupper(Str::random($length));
            //如果已经存在就继续循环
        }while(self::query()->where('code',$code)->exists());
        return $code;
    }

    public function getDescriptionAttribute()
    {
        //满 XXX 优惠 百分之多少  ，  满xxxx 减 xxx
        $str = '';
        if($this->min_amount > 0){
            $str = '满'.$this->min_amount;
        }
        if($this->type == self::TYPE_PERCENT){
           return $str.'优惠'.str_replace('.00','',$this->value).'%';
        }
        return $str.'减'.str_replace('.00','',$this->value);
    }
}
