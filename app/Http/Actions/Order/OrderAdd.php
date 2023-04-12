<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Offer;
use App\Models\Order;
use App\Notifications\SmsVNewOrder;
use Illuminate\Support\Facades\Notification;

class OrderAdd implements ActionInterface
{
    public function execute(array $data)
    {
        $data['status'] = OrderStatusEnum::new->name;
        $offer = Offer::find($data['offer_id']);
        $data['manager_id'] = $offer->manager_id;
        $data['provider_id'] = $offer->provider_id;
        if (!isset($data['email'])) {
            $data['email'] = '';
        }
        $phone  = str_replace('+7(', '8(', $data['phone']);
        $phone  = str_replace(['-','_','','+','(',')'], '', $phone);
        $data['phone'] = $phone;
        $data['bill_id'] = 0;
        $order = Order::create($data);
        $order->events()->create([
            'code' => OrderEventEnum::new->name,
            'comment' => $data['comment'],
            'user_id' => 0,
        ]);
        $offer->orders_count += 1;
        $offer->save();
        $statistic = $offer->statistic()->first();
        $statistic->new = $statistic->new + 1;
        $statistic->save();
        $owner = $offer->provider()->first()->managers()->where('owner', 1)->first();
        Notification::send($owner->user()->first(), new SmsVNewOrder());
        return ['id'=>$order->id];

    }
}
