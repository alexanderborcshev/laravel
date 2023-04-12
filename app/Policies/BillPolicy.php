<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BillPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    public function moderator(User $user): Response|bool
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    public function accountant(User $user): Response|bool
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::accountant->name]);
    }

    public function provider(User $user, Bill $bill): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::moderator->name])) {
            return true;
        }
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->provider_id == $bill->provider_id) {
            return true;
        }
        return false;
    }

    public function provider_owner(User $user): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->owner) {
            return true;
        }
        return false;
    }
}
