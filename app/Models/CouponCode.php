<?php

namespace App\Models;

use App\Exceptions\CouponCodeUnavailableException;
use Carbon\Carbon;
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
        'not_before', 'not_after'
    ];

    protected $appends = ['description'];

    //生成优惠码
    public static function findAvailableCode($length = 16)
    {
        do {
            //生成指定长度的随机字符串，并转成大写
            $code = strtoupper(Str::random($length));
            //如果已经存在就继续循环
        } while (self::query()->where('code', $code)->exists());
        return $code;
    }

    public function getDescriptionAttribute()
    {
        //满 XXX 优惠 百分之多少  ，  满xxxx 减 xxx
        $str = '';
        if ($this->min_amount > 0) {
            $str = '满' . $this->min_amount;
        }
        if ($this->type == self::TYPE_PERCENT) {
            return $str . '优惠' . str_replace('.00', '', $this->value) . '%';
        }
        return $str . '减' . str_replace('.00', '', $this->value);
    }

    public function checkAvailable(User $user,$orderAmount = null)
    {
        if (!$this->enabled) {
            throw new CouponCodeUnavailableException('优惠券不存在');
        }
        if ($this->total - $this->used <= 0) {
            throw new CouponCodeUnavailableException('优惠券已兑完');
        }
        if ($this->not_before && $this->not_before->gt(Carbon::now())) {
            throw new CouponCodeUnavailableException('该优惠券现在还不能使用');
        }
        if ($this->not_after && $this->not_after->lt(Carbon::now())) {
            throw new CouponCodeUnavailableException('该优惠券已过期');
        }
        if (!is_null($orderAmount) && $orderAmount < $this->min_amount) {
            throw new CouponCodeUnavailableException('订单金额不满足优惠券最低金额');
        }
        $used = Order::where('user_id',$user->id)
            ->where('coupon_code_id',$this->id)
            ->where(function($query){
                $query->where(function($query){
                    //未支付且未关闭
                    $query->whereNull('paid_at')
                        ->where('closed',false);
                })->orWhere(function($query){
                    //已支付且未退款成功
                    $query->whereNotNull('paid_at')
                        ->where('refund_status','!=',Order::REFUND_STATUS_SUCCESS);
                });
            })
            ->exists();
        if($used){
            throw new CouponCodeUnavailableException('你已经使用过该优惠券了');
        }
    }

    public function getAdjustedPrice($orderAmount)
    {
        //固定金额
        if ($this->type === self::TYPE_FIXED) {
            return max(0.01, $orderAmount - $this->value);
        }
        return number_format($orderAmount * (100 - $this->value) / 100, 2, '.', '');
    }

    public function changeUsed($increase = true)
    {
        // 传入 true 代表新增用量，否则是减少用量
        if($increase){
            // 与检查 SKU 库存类似，这里需要检查当前用量是否已经超过总量
            return $this->where('id',$this->id)->where('used','<',$this->total)->increment('used');
        }else{
            return $this->decrement('used');
        }
    }
}
