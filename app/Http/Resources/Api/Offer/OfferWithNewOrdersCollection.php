<?php

namespace App\Http\Resources\Api\Offer;

use App\Http\Resources\Api\Order\OrderListResource;
use App\Http\Resources\Api\Provider\ProviderForOrderResource;
use App\Http\Resources\Api\User\ManagerForOrderResource;
use App\Models\Enums\OrderStatusEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class OfferWithNewOrdersCollection extends ResourceCollection
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
            $oldest = $data->orders()->oldest()->first();
            return [
                'oldest_order_date_timestamp' => $oldest ? strtotime($oldest->created_at) : 0,
                'name' => $data->name,
                'statistic' => $data->statistic,
                'provider' => new ProviderForOrderResource($data->provider),
                'orders' => OrderListResource::collection($data->orders()->where('status', OrderStatusEnum::new->name)->oldest()->get()),
                'manager' => $data->managerw ? new ManagerForOrderResource($data->managerw->user) : [],
                'id' => $data->id,
            ];
        });
        return $this->collection->sortBy('oldest_order_date_timestamp')->all();
    }
}
