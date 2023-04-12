<?php

namespace App\Policies;

use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Order;
use App\Models\Provider;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Order $order
     * @return Response|bool
     */
    public function view(User $user, Order $order): Response|bool
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return true;
    }

    public function provider(User $user, Order $order): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::moderator->name])) {
            return true;
        }
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->provider_id == $order->provider_id) {
            return true;
        }
        return false;
    }

    public function accept(User $user, Order $order): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::moderator->name])) {
            return true;
        }
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->provider_id == $order->provider_id) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Order $order
     * @return Response|bool
     */
    public function verify(User $user, Order $order): Response|bool
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function search(User $user): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::moderator->name])) {
            return true;
        }
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name])) {
            return true;
        }
        return false;
    }
    public function status(User $user, Order $order): Response|bool
    {
        if ($user->inGroupsByCode([UserGroupCodeEnum::moderator->name])) {
            return true;
        }
        if ($user->inGroupsByCode([UserGroupCodeEnum::provider->name]) && $user->managers()->first()->provider_id == $order->provider_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param UserNote $userNote
     * @return Response|bool
     */
    public function update(User $user, Order $order): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Order $order
     * @return Response|bool
     */
    public function delete(User $user, Order $order): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param UserNote $userNote
     * @return Response|bool
     */
    public function restore(User $user, Order $order): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param UserNote $userNote
     * @return Response|bool
     */
    public function forceDelete(User $user, Order $order): Response|bool
    {
        return false;
    }
}
