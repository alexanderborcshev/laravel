<?php

namespace App\Http\Resources\Api\Order;

use App\Http\Resources\Api\Offer\OfferSearchResource;
use App\Http\Resources\Api\Provider\ProviderForOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderModeratorSearchListResource extends JsonResource
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
            'events' => OrderEventResource::collection($this->events()->latest()->get()),
            'status' => $this->status,
            'phone' => $this->phone_format,
            'email' => $this->email,
            'name' => $this->name,
            'date' => $this->created_date,
            'date_only' => $this->created_date_only,
            'time' => $this->created_time,
            'day_diff' => $this->created_day_diff,
            'accepted' => $this->accepted,
            'verified' => $this->verified,
            'opened' => false,
            'max_height' => 0,
            'id' => $this->id,
            'how_connect' => $this->how_connect,
            'price' => $this->price,
            'offer_id' => $this->offer_id,
            'offer' => new OfferSearchResource($this->offer),
        ];
    }
}
