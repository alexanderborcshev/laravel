<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderPostponeEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderPostpone implements ActionInterface
{
    public function execute(array $data): void
    {
        $order = Order::find($data['id']);
        $invalidStatuses = [OrderStatusEnum::postpone->name, OrderStatusEnum::finished->name];
        $currentStatus = $order->status;
        if (in_array($order->status, $invalidStatuses)) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        $order->status = OrderStatusEnum::postpone->name;
        $order->postpone = $data['postpone'];
        $order->updated_at = date('Y-m-d H:i:s');
        $postpone = match ($data['postpone']) {
            OrderPostponeEnum::week->name => '1 нед.',
            OrderPostponeEnum::month->name => '1 мес.',
            OrderPostponeEnum::three_month->name => '3 мес.',
            OrderPostponeEnum::six_month->name => '6 мес.',
        };
        $order->events()->create([
            'user_id' => auth()->id(),
            'comment' => '<b>Отложен на '.$postpone.'</b> '.$data['comment'],
            'code' => OrderEventEnum::postpone->name,
        ]);
        $order->save();
        $statistic = $order->offer->statistic()->first();
        $statistic->postpone = $statistic->postpone + 1;
        switch ($currentStatus) {
            case OrderStatusEnum::new->name:
                $statistic->new = $statistic->new - 1;
                break;
            case OrderStatusEnum::in_progress->name:
                $statistic->in_progress = $statistic->in_progress - 1;
                break;
            case OrderStatusEnum::canceled->name:
                $statistic->canceled = $statistic->canceled - 1;
                break;
        }
        $statistic->negativeToZeroValue();
        $statistic->save();
    }
}
