<?php

namespace App\Policies;

use App\Models\Enums\UserGroupCodeEnum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ManagerPolicy
{
    use HandlesAuthorization;

    public function provider_owner(User $user): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->owner) {
            return true;
        }
        return false;
    }
}
