<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province', 'city', 'district', 'address', 'zip', 'contact_name', 'contact_phone', 'last_used_at'
    ];

    protected $dates = ['last_used_at'];

    //一对多；一个用户拥有多一个地址
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //访问器：$address->full_address 来获取完整的地址,不用每次都拼接
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }

}
