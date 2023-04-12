<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Notifications\SmsVNewOrder;
use App\Notifications\SmsZOrderCancel;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderCancel implements ActionInterface
{
    public function execute(array $data): void
    {
        $order = Order::find($data['id']);
        $currentStatus = $order->status;
        $invalidStatuses = [OrderStatusEnum::canceled->name, OrderStatusEnum::finished->name];
        if (in_array($order->status, $invalidStatuses)) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        $order->status = OrderStatusEnum::canceled->name;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->events()->create([
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
            'code' => OrderEventEnum::canceled->name,
        ]);
        $order->save();
        $statistic = $order->offer->statistic()->first();
        $statistic->canceled = $statistic->canceled + 1;
        switch ($currentStatus) {
            case OrderStatusEnum::new->name:
                $statistic->new = $statistic->new - 1;
                break;
            case OrderStatusEnum::in_progress->name:
                $statistic->in_progress = $statistic->in_progress - 1;
                break;
            case OrderStatusEnum::postpone->name:
                $statistic->postpone = $statistic->postpone - 1;
                break;
        }
        $statistic->negativeToZeroValue();
        $statistic->save();
        Notification::send($order, new SmsZOrderCancel());
    }
}
