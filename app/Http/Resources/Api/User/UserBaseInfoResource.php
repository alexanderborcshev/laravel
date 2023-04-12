<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserBaseInfoResource extends JsonResource
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
            'blocked'   => $this->blocked,
        ];
    }
}
