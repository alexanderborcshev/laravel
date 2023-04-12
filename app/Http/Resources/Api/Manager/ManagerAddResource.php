<?php

namespace App\Http\Resources\Api\Manager;

use App\Http\Resources\Api\User\UserBaseInfoResource;
use App\Models\Enums\OrderStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerAddResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner' => $this->owner,
            'provider_id' => $this->provider_id,
            'order_count' => 0,
            'order_price' => 0,
            'user' => new UserBaseInfoResource($this->user),
        ];
    }
}
