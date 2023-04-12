<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Notifications\SmsZOrderCompleted;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderFinish implements ActionInterface
{
    public function execute(array $data): void
    {
        $order = Order::find($data['id']);
        $currentStatus = $order->status;
        if ($order->status == OrderStatusEnum::finished->name) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        $order->status = OrderStatusEnum::finished->name;
        $order->commission = $order->offer->commission;
        $order->price = $data['price'];
        $order->updated_at = date('Y-m-d H:i:s');
        $order->events()->create([
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
            'code' => OrderEventEnum::finished->name,
        ]);
        $order->save();
        $statistic = $order->offer->statistic()->first();
        $statistic->finished = $statistic->finished + 1;
        $statistic->profit = $statistic->profit + $data['price'];
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
            case OrderStatusEnum::canceled->name:
                $statistic->canceled = $statistic->canceled - 1;
                break;
        }
        $statistic->negativeToZeroValue();
        $statistic->save();
        Notification::send($order, new SmsZOrderCompleted(['sum'=>number_format($data['price'], 0, '.',' ')]));
    }
}
