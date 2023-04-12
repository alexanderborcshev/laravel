<?php

namespace App\Http\Middleware;

use App\Http\Resources\Api\Auth\AuthBannedResource;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResource|JsonResponse
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::user() && Auth::user()?->blocked) {
            return new AuthBannedResource(Auth::user());
        }
        if ($request->input('login')) {
            $user = (new User)->getByLogin(str_replace(['-','_','','+','(',')'], '', $request->input('login')))->first();
            if ($user && $user->blocked) {
                return new AuthBannedResource($user);
            } else {
                return $next($request);
            }
        }
        return $next($request);
    }
}
