<?php

namespace App\Http\Resources\Api\Offer;

use App\Http\Resources\Api\Provider\ProviderForOrderResource;
use App\Http\Resources\Public\Category\CategoryResource;
use App\Http\Resources\Public\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'preview' => new FileResource($this->main_photo),
            'provider' => new ProviderForOrderResource($this->provider),
            'status' => $this->status,
            'number' => $this->number ?: '',
            'category' => new CategoryResource($this->category),
            'updated_day_diff' => $this->updated_day_diff,
            'pause_comment' => $this->pause_comment,
            'manager_id' => $this->manager_id,
        ];
    }
}
