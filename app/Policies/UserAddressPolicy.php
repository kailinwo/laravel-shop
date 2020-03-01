<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserAddressPolicy
{
    use HandlesAuthorization;

    public function own(User $currentUser, UserAddress $address)
    {
        return $currentUser->id == $address->user_id;
    }
}
