<?php

namespace App\Http\Actions\Provider;

use App\Http\Actions\ActionInterface;
use App\Models\Provider;
use Illuminate\Support\Collection;

class ProviderForOfferModeratorList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        return Provider::where('status', 'active')->get();
    }
}
