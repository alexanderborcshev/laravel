<?php

namespace App\Http\Resources\Api\Provider;

use App\Http\Resources\Api\Offer\OfferModeratorMenuResource;
use App\Models\Enums\OfferStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDetailWithOfferResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $return = (new ProviderDetailResource($request))->toArray($request);
        $return['offers'] = OfferModeratorMenuResource::collection($this->offers()->whereIn('status', [OfferStatusEnum::public->name, OfferStatusEnum::paused->name])->get());
        return $return;
    }
}
