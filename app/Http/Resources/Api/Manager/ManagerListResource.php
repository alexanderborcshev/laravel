<?php

namespace App\Http\Resources\Api\Manager;

use App\Http\Resources\Api\User\UserBaseInfoResource;
use App\Models\Enums\OrderStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders = $this->orders()->where('status', OrderStatusEnum::finished->name)->get();
        $order_price = 0;
        $order_count = 0;
        foreach ($orders as $order) {
            $order_price += $order->price;
            $order_count += 1;
        }
        return [
            'id' => $this->id,
            'owner' => $this->owner,
            'provider_id' => $this->provider_id,
            'order_count' => $order_count,
            'order_price' => $order_price,
            'user' => new UserBaseInfoResource($this->user),
        ];
    }
}
