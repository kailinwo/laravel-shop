<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function own(User $currentUser, Order $order)
    {
        return $currentUser->id == $order->user_id;
    }
}
