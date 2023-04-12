<?php

namespace App\Http\Resources\Api\Order;

use App\Models\Enums\OrderEventEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderForBillResource extends JsonResource
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
            'event_finish' => new OrderEventResource($this->events()->where('code', OrderEventEnum::finished->name)->first()),
            'status' => $this->status,
            'phone' => $this->phone_format,
            'name' => $this->name,
            'date' => $this->created_date,
            'date_only' => $this->created_date_only,
            'time' => $this->created_time,
            'price' => $this->price,
            'commission' => $this->commission,
            'max_height' => 0,
            'id' => $this->id,
            'offer_id' => $this->offer_id,
            'bill_id' => $this->bill_id,
        ];
    }
}
