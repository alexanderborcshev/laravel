<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;

class OfferPause implements ActionInterface
{
    public function execute(array $data): void
    {
        $offer = Offer::find($data['id']);
        $offer->status = OfferStatusEnum::paused->name;
        $offer->updated_at = date('Y-m-d H:i:s');
        $offer->pause_comment = $data['comment'];
        $offer->save();
    }
}
