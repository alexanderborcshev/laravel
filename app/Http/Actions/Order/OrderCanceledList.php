<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Support\Collection;

class OrderCanceledList implements ActionInterface
{
    public function execute(array $data = []): Collection|array
    {
        return Order::where('status', OrderStatusEnum::canceled->name)->get();
    }
}
