<?php

namespace App\Http\Resources\Api\Auth;

use App\Models\Enums\ErrorCodeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthRateLimitLoginResource extends JsonResource
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
            'message' => 'Sms rate limiting',
            'errorCode' => ErrorCodeEnum::RateLimitingLogin->value,
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
        $response->setStatusCode(ResponseAlias::HTTP_TOO_MANY_REQUESTS);
    }
}
