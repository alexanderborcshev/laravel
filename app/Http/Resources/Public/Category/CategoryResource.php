<?php

namespace App\Http\Resources\Public\Category;

use App\Models\Enums\OfferStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'icon' => $this->icon,
            'count' => $this->offers()->where('status', OfferStatusEnum::public->name)->count(),
        ];
    }
}
