<?php

namespace App\Http\Resources\Api\Offer;

use App\Http\Resources\Api\Provider\ProviderForOrderResource;
use App\Http\Resources\Api\User\ManagerForOrderResource;
use App\Http\Resources\Public\Category\CategoryResource;
use App\Http\Resources\Public\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferModeratorMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number ?: '',
            'manager' => new ManagerForOrderResource($this->manager->user),
        ];
    }
}
