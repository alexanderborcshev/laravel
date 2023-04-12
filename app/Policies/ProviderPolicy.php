<?php

namespace App\Policies;

use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProviderPolicy
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

    public function provider(User $user, Offer $offer): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::moderator->name])) {
            return true;
        }
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->provider_id == $offer->provider_id) {
            return true;
        }
        return false;
    }
}
