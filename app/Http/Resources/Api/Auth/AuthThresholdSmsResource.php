<?php

namespace App\Http\Resources\Api\Auth;

use App\Http\Resources\Api\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Cookie;

class AuthThresholdSmsResource extends JsonResource
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
            'status' => 'threshold',
            'threshold' => $this->resource['threshold'],
        ];
    }
}
