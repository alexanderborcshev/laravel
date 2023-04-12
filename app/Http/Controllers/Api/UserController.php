<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\User\UserFirst;
use App\Http\Actions\User\UserRule;
use App\Http\Resources\Api\User\UserProfileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function profile(): UserProfileResource
    {
        $user = Auth::user();
        return new UserProfileResource($user);
    }
    public function first(UserFirst $action): JsonResponse
    {
        $action->execute([]);
        return response()->json();
    }
    public function rule(UserRule $action): JsonResponse
    {
        $action->execute([]);
        return response()->json();
    }
}
