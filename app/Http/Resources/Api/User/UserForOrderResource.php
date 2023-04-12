<?php

namespace App\Http\Resources\Api\User;

use App\Models\Enums\UserGroupCodeEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserForOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'second_name' => $this->second_name,
            'last_name'   => $this->last_name,
            'email' => $this->email,
            'login'   => $this->login,
            'login_to_phone'   => $this->login_to_phone,
            'moderator'   => $this->inGroupsByCode([UserGroupCodeEnum::moderator->name]),
        ];
    }
}
