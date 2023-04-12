<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Http\Resources\Api\Offer\OfferSearchResource;
use App\Http\Resources\Api\Order\OrderModeratorSearchListResource;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;

class SearchModerator implements ActionInterface
{
    public function execute(array $data = []): Collection|array
    {
        $phone  = str_replace(['-','_','','+','(',')'], '', $data['query']);
        $items = Order::where('phone','LIKE', $phone.'%')->limit(100);

        return [
            'orders' => OrderModeratorSearchListResource::collection($items->get()),
            'offers' => [],
        ];
    }
}
