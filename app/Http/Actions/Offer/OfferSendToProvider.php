<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;

class OfferSendToProvider implements ActionInterface
{
    public function execute(array $data): void
    {
        $offer = Offer::find($data['id']);
        $offer->status = OfferStatusEnum::wait_public->name;
        $offer->updated_at = date('Y-m-d H:i:s');
        $offer->save();
    }
}
