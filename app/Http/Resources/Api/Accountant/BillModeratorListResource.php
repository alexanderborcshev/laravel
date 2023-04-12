<?php

namespace App\Http\Resources\Api\Accountant;

use App\Http\Resources\Api\Provider\ProviderFoBillResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillModeratorListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'status' => $this->status,
            'provider' => new ProviderFoBillResource($this->provider),
            'sum' => $this->sum,
            'profit' => $this->profit,
            'number' => $this->number,
            'send' => $this->send,
            'accept_date' => $this->accept_date_only,
            'used_date' => $this->used_date_only,
            'created_date' => $this->created_date,
            'orders' => $this->orders()->count(),
        ];
    }
}
