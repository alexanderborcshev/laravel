<?php

namespace App\Http\Resources\Api\Offer;

use App\Http\Resources\Public\Category\CategoryResource;
use App\Http\Resources\Public\FileResource;
use App\Http\Resources\Public\Provider\ProviderModalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferPartnerDetailResource extends JsonResource
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
            'price_min' => $this->price_min,
            'price_max' => $this->price_max,
            'orders' => $this->orders,
            'prices' => $this->prices,
            'images' => FileResource::collection($this->images),
            'main_photo' => $this->main_photo ? new FileResource($this->main_photo) : [],
            'main_text' => $this->main_text,
            'advantages' => $this->advantages,
            'main_text_title' => $this->main_text_title,
            'text_sections' => $this->text_sections,
            'gifts' => $this->gifts,
            'work_time' => $this->work_time,
            'description' => $this->description,
            'provider' => new ProviderModalResource($this->provider),
            'category' => new CategoryResource($this->category),
            'commission' => $this->commission,
            'status' => $this->status,
            'manager_id' => $this->manager_id,
        ];
    }
}
