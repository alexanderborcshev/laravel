<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserNoteResource extends JsonResource
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
            'creator' => new UserForOrderResource($this->creator),
            'comment' => $this->comment,
            'date_diff' => $this->created_date_diff,
            'date' => $this->created_date,
            'user_id' => $this->user_id,
        ];
    }
}
