<?php

namespace App\Http\Actions\Auth;

use App\Http\Actions\ActionInterface;
use App\Http\Resources\Api\Auth\AuthRefreshTokenExpired;
use App\Http\Resources\Api\Auth\AuthSuccessResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AuthRefreshToken implements ActionInterface
{
    protected mixed $oauth_client;

    public function __construct()
    {
        $this->oauth_client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();
    }

    /**
     * @throws Exception
     */
    public function execute(array $data): JsonResource
    {
        $dataOauth = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->oauth_client->id,
            'client_secret' => $this->oauth_client->secret,
            'refresh_token' => $data['refresh_token'],
        ];

        $requestToken = Request::create('/oauth/token', 'POST', $dataOauth);
        $requestToken = json_decode(app()->handle($requestToken)->getContent(),true);
        if(isset($requestToken['error'])) {
            return new AuthRefreshTokenExpired([]);
        }
        return new AuthSuccessResource([
            'request_token' => $requestToken,
        ]);
    }
}
