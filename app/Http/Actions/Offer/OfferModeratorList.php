<?php

namespace App\Http\Actions\Offer;

use App\Http\Actions\ActionInterface;
use App\Models\Offer;
use Illuminate\Support\Collection;

class OfferModeratorList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        $orderBy = 'updated_at';
        $direction = 'desc';
        if ($data['status'] == 'new') {
            $orderBy = 'created_at';
        }
        if ($data['status'] == 'wait_public') {
            $direction = 'asc';
        }
        return Offer::where('status', $data['status'])->orderBy($orderBy, $direction)->get();
    }
}
