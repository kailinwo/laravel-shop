<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressesController extends Controller
{
    /*
     * 收货地址列表
     */
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses,
        ]);
    }

    /*
     * 添加收货地址页面
     */
    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }

    //保存收货地址
    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province', 'city', 'district', 'address', 'zip', 'contact_name', 'contact_phone'
        ]));
        return redirect()->route('user_address.index');
    }

    //修改地址页面
    public function edit(UserAddress $user_address)
    {
        return view('user_addresses.create_and_edit', ['address' => $user_address]);
    }

    //保存地址页面
    public function update(UserAddress $userAddress, UserAddressRequest $request)
    {
        $userAddress->update($request->only([
            'province', 'city', 'district', 'address', 'zip', 'contact_name', 'contact_phone'
        ]));
        return redirect()->route('user_address.index');
    }

    //删除地址
    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        $user_address->delete();
//        return redirect()->route('user_address.index');
        return [];
    }
}
