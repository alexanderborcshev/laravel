<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Offer;
use App\Models\Provider;

class OfferDelete implements ActionInterface
{
    public function execute(array $data): void
    {
        Offer::find($data['id'])->delete();
    }
}
