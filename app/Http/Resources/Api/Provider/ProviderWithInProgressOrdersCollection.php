<?php

namespace App\Http\Resources\Api\Provider;

use App\Models\Enums\OrderStatusEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ProviderWithInProgressOrdersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $this->collection = $this->collection->map(function ($data) {
            $oldestOrder = $data->orders()->oldest()->first();
            return [
                'oldest_order_date_timestamp' => strtotime($oldestOrder->created_at),
                'oldest_order_date_day' => $oldestOrder->created_at->diffInDays(),
                'offer' => $oldestOrder->offer_id,
                'name' => $data->name,
                'orders_count' => $data->orders()->where('status', OrderStatusEnum::in_progress->name)->oldest()->count(),
                'id' => $data->id,
            ];
        });
        return $this->collection->sortBy('oldest_order_date_timestamp')->all();
    }
}
