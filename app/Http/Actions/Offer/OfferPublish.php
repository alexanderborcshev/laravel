<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;

class OfferPublish implements ActionInterface
{
    public function execute(array $data): array
    {
        $offer = Offer::find($data['id']);
        $offerNumberLast = Offer::where('provider_id', $offer->provider_id)->orderByDesc('number')->first()->number;
        $offer->status = OfferStatusEnum::public->name;
        $offer->updated_at = date('Y-m-d H:i:s');
        $offer->number = $offerNumberLast + 1;
        $offer->save();
        $offerRedirect = Offer::where('provider_id', $offer->provider_id)
            ->where('status', OfferStatusEnum::wait_public->name)
            ->first();
        $result = [
            'offer_redirect' => false,
        ];
        if ($offerRedirect) {
            $result['offer_redirect'] = $offer->id;
        }
        return $result;
    }
}
