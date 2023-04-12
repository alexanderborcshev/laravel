<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Order;
use App\Models\OrderEvent;

class OrderVerify implements ActionInterface
{
    public function execute(array $data): OrderEvent
    {
        $order = Order::find($data['id']);
        $order->verified = true;
        $order->save();
        return OrderEvent::create([
            'order_id' => $data['id'],
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
            'code' => OrderEventEnum::verified->name,
        ]);
    }
}
