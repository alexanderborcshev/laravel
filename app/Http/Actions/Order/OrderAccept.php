<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Order;

class OrderAccept implements ActionInterface
{
    public function execute(array $data): void
    {
        $order = Order::find($data['id']);
        $order->accepted = true;
        $order->save();
    }
}
