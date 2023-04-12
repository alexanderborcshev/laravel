<?php

namespace App\Http\Actions\Auth;

use App\Http\Actions\ActionInterface;
use App\Http\Resources\Api\Auth\AuthRateLimitLoginResource;
use App\Http\Resources\Api\Auth\AuthSuccessResource;
use App\Http\Resources\Api\Auth\AuthInvalidPasswordResource;
use App\Http\Resources\Api\Auth\AuthBannedResource;
use App\Models\AuthBlock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthLogin implements ActionInterface
{
    protected mixed $oauth_client;

    public function __construct()
    {
        $this->oauth_client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
    }

    public function execute(array $data): JsonResource
    {
        $user = (new User)->getByLogin($data['login'])->first();
        if ($user && $user->blocked) {
            return new AuthBannedResource($user);
        }

        if (!$user || !Hash::check($data['password'], $user->sms_hash)) {
            return new AuthInvalidPasswordResource([]);
        }

        if(!AuthBlock::checkLogin(request()->ip(), $data['login'])) {
            return new AuthRateLimitLoginResource([]);
        }

        AuthBlock::getByIP(request()->ip())->clearAll();
        AuthBlock::getByLogin($data['login'])->clearAll();

        $data = [
            'grant_type' => 'password',
            'client_id' => $this->oauth_client->id,
            'client_secret' => $this->oauth_client->secret,
            'username' => $data['login'],
            'password' => $data['password'],
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $data);
        $requestToken = json_decode(app()->handle($requestToken)->getContent(),true);
        return new AuthSuccessResource([
            'user' => $user,
            'request_token' => $requestToken,
        ]);
    }
}
