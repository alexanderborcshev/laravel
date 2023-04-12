<?php

namespace App\Http\Resources\Api\Offer;

use App\Http\Resources\Api\Provider\ProviderForOrderResource;
use App\Http\Resources\Public\Category\CategoryResource;
use App\Http\Resources\Public\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferProviderMenuResource extends JsonResource
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
        ];
    }
}
