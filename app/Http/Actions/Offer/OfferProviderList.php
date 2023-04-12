<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;
use Illuminate\Support\Collection;

class OfferProviderList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        $orderBy = 'created_at';
        $direction = 'desc';
        $provider_id = auth()->user()->managers()->first()->provider_id;
        return Offer::where('provider_id', $provider_id)
            ->orderBy($orderBy, $direction)
            ->whereNot('status', OfferStatusEnum::new->name)
            ->get();
    }
}
