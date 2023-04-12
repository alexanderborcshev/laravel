<?php

namespace App\Http\Resources\Api\Order;

use App\Http\Resources\Api\User\UserForOrderResource;
use App\Models\Enums\ErrorCodeEnum;
use App\Models\Enums\OrderEventEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderEventResource extends JsonResource
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
            'user' => $this->user ? new UserForOrderResource($this->user) : [],
            'comment' => $this->comment,
            'name' => OrderEventEnum::valueByStringName($this->code),
            'code' => $this->code,
            'date' => $this->created_date_diff,
            'date_only' => $this->created_date_only,
            'time' => $this->created_time,
            'order_id' => $this->order_id,
            'id' => $this->id,
        ];
    }
}
