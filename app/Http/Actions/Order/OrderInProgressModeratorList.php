<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Provider;
use Illuminate\Support\Collection;

class OrderInProgressModeratorList implements ActionInterface
{
    public function execute(array $data = []): Collection|array
    {
        $orders = Order::where('status', OrderStatusEnum::in_progress->name);
        $orders->groupBy('provider_id');

        $providersId = $orders->pluck('provider_id')
            ->toArray();
        return Provider::whereIn('id', $providersId)->get();
    }
}
