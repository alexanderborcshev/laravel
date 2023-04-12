<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticateConsole
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->input('key') === env('CONSOLE_KEY')) {
            return $next($request);
        }
        return response('',ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
