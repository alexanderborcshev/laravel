<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;
use Illuminate\Support\Collection;

class OffersStatisticUpdate implements ActionInterface
{
    public function execute(array $data)
    {
        $offers = Offer::all();
        foreach ($offers as $offer) {
            $offer->updateStatistic();
        }
    }
}
