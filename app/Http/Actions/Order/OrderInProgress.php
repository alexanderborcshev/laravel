<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderInProgress implements ActionInterface
{
    public function execute(array $data): void
    {
        $order = Order::find($data['id']);
        $invalidStatuses = [OrderStatusEnum::in_progress->name, OrderStatusEnum::finished->name];
        $currentStatus = $order->status;
        if (in_array($order->status, $invalidStatuses)) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        $order->status = OrderStatusEnum::in_progress->name;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->events()->create([
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
            'code' => OrderEventEnum::in_progress->name,
        ]);
        $order->save();
        $statistic = $order->offer->statistic()->first();
        $statistic->in_progress = $statistic->in_progress + 1;
        switch ($currentStatus) {
            case OrderStatusEnum::new->name:
                $statistic->new = $statistic->new - 1;
                break;
            case OrderStatusEnum::postpone->name:
                $statistic->postpone = $statistic->postpone - 1;
                break;
            case OrderStatusEnum::canceled->name:
                $statistic->canceled = $statistic->canceled - 1;
                break;
        }
        $statistic->negativeToZeroValue();
        $statistic->save();
    }
}
