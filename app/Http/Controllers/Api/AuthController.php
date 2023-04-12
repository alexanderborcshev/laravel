<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\Auth\AuthLogin;
use App\Http\Actions\Auth\AuthRefreshToken;
use App\Http\Actions\Auth\AuthSmsSend;
use App\Http\Requests\Api\Auth\AuthCheckLoginRequest;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\Api\Auth\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    /**
     * @throws ValidationException|Exception
     */
    public function login(AuthRequest $request, AuthLogin $action): JsonResource
    {
        return $action->execute($request->validated());
    }

    public function check(AuthCheckLoginRequest $request, AuthSmsSend $action): JsonResource
    {
        return $action->execute($request->validated());
    }

    /**
     * @throws Exception
     */
    public function refresh_token(Request $request, AuthRefreshToken $action): JsonResource
    {
        return $action->execute(['refresh_token'=>$request->refresh_token]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->authAccessToken()->delete();
        return response()->json();
    }
}
