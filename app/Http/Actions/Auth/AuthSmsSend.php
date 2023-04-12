<?php

namespace App\Http\Actions\Auth;

use App\Http\Actions\ActionInterface;
use App\Http\Resources\Api\Auth\AuthRateLimitLoginResource;
use App\Http\Resources\Api\Auth\AuthRateLimitSmsResource;
use App\Http\Resources\Api\Auth\AuthSmsSendResource;
use App\Http\Resources\Api\Auth\AuthThresholdSmsResource;
use App\Http\Resources\Api\Auth\AuthBannedResource;
use App\Http\Resources\Api\Auth\AuthInvalidLoginResource;
use App\Models\AuthBlock;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class AuthSmsSend implements ActionInterface
{
    protected mixed $oauth_client;
    protected string $rate_limit_key;
    public function __construct()
    {
        $this->oauth_client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
        $this->rate_limit_key = 'send-sms-login:'.request()->ip();
    }

    public function execute(array $data): JsonResource
    {
        $user = (new User)->getByLogin($data['login'])->first();
        if ($user && $user->blocked) {
            return new AuthBannedResource($user);
        }
        if(!$user) {
            return new AuthInvalidLoginResource([]);
        }
        $seconds = RateLimiter::availableIn($this->rate_limit_key);
        if (RateLimiter::tooManyAttempts($this->rate_limit_key, 1)) {
            return new AuthThresholdSmsResource(['threshold'=>$seconds]);
        }
        if(!AuthBlock::checkLogin(request()->ip(), $data['login'])) {
            return new AuthRateLimitLoginResource([]);
        }
        if(!AuthBlock::checkSms(request()->ip(), $data['login'])) {
            return new AuthRateLimitSmsResource([]);
        }

        RateLimiter::hit($this->rate_limit_key,30);
        $user->sendSmsCode();
        return new AuthSmsSendResource($this->oauth_client);
    }
}
