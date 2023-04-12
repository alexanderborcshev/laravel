<?php

namespace App\Http\Resources\Public\Offer;

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
        return[
            'id' => $this->id,
            'name' => $this->name,
            'preview' => new FileResource($this->main_photo),
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'orders' => count($this->orders),
            'category' => new CategoryResource($this->category),
        ];
    }
}
