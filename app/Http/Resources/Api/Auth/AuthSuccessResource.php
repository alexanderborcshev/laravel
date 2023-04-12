<?php

namespace App\Http\Resources\Api\Auth;

use App\Http\Resources\Api\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Cookie;

class AuthSuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'user' => isset($this->resource['user'])  ? new UserProfileResource($this->resource['user']) : [],
            'refresh_token' => $this->resource['request_token']['refresh_token'] ?? '',
            'resource' => $this->resource,
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        if (isset($this->resource['request_token']['access_token'])) {
            $response->cookie(Passport::cookie(),  $this->resource['request_token']['access_token'], 15*24*60, '/', null, null, true, false, Cookie::SAMESITE_NONE);
        }
    }
}
