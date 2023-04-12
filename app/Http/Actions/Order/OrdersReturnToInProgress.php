<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderPostponeEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrdersReturnToInProgress implements ActionInterface
{
    public function execute(array $data)
    {
        $orders = Order::where('status', OrderStatusEnum::postpone->name)->get();
        foreach ($orders as $order) {
            $date = Carbon::createFromTimestamp($order->updated_at->getTimestamp());
            switch ($order->postpone) {
                case OrderPostponeEnum::week->name:
                    $date->addDays(7);
                    break;
                case OrderPostponeEnum::month->name:
                    $date->addMonth();
                    break;
                case OrderPostponeEnum::three_month->name:
                    $date->addMonths(3);
                    break;
                case OrderPostponeEnum::six_month->name:
                    $date->addMonths(6);
                    break;
            }
            if (time() > $date->timestamp) {
                $order->status = OrderStatusEnum::in_progress->name;
                $order->updated_at = date('Y-m-d H:i:s');
                $order->events()->create([
                    'user_id' => 0,
                    'comment' => 'Заказ был отложен, срок откладывания истек',
                    'code' => OrderEventEnum::in_progress->name,
                ]);
                $order->save();
            }
        }
        return $orders;
    }
}
