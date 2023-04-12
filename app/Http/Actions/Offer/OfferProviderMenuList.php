<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;
use Illuminate\Support\Collection;

class OfferProviderMenuList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        $manager = auth()->user()->managers()->first();
        $provider_id = $manager?->provider_id;
        if ($provider_id) {
            if ($manager->owner) {
                return Offer::whereIn('status', [OfferStatusEnum::public->name, OfferStatusEnum::paused->name])
                    ->where('provider_id', $provider_id)
                    ->orderByDesc('number')
                    ->get();
            }
            return Offer::whereIn('status', [OfferStatusEnum::public->name, OfferStatusEnum::paused->name])
                ->where('provider_id', $provider_id)
                ->where('manager_id', $manager->id)
                ->orderByDesc('number')
                ->get();
        }
        return [];
    }
}
