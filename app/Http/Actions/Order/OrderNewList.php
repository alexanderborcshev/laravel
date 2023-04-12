<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Support\Collection;

class OrderNewList implements ActionInterface
{
    public function execute(array $data = []): Collection|array
    {
        $orders = Order::where('status', OrderStatusEnum::new->name);
        if(isset($data['provider_id'])) {
            $orders->where('provider_id', $data['provider_id']);
        }
        $orders->groupBy('offer_id');

        $offersId = $orders->pluck('offer_id')
            ->toArray();
        return Offer::whereIn('id', $offersId)->get();
    }
}
