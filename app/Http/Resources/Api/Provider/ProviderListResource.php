<?php

namespace App\Http\Resources\Api\Provider;

use App\Http\Resources\Api\Offer\OfferForProviderListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'legal_entity' => $this->legal_entity,
            'offers' => OfferForProviderListResource::collection($this->offers),
        ];
    }
}
