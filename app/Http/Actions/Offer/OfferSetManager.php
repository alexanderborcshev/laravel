<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;

class OfferSetManager implements ActionInterface
{
    public function execute(array $data): void
    {
        $offer = Offer::find($data['id']);
        $offer->manager_id = $data['manager_id'];
        $offer->save();
    }
}
