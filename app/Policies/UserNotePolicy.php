<?php

namespace App\Policies;

use App\Models\Enums\UserGroupCodeEnum;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserNotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserNote $userNote)
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->inGroupsByCode([UserGroupCodeEnum::moderator->name]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserNote $userNote)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserNote $userNote)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserNote $userNote)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserNote  $userNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserNote $userNote)
    {
        return false;
    }
}
