<?php

namespace App\Http\Actions\User;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\UserNote;
use Illuminate\Support\Facades\Auth;

class Counter implements ActionInterface
{
    public function execute(array $data): array
    {
        $provider_id = $data['provider_id'] ?? auth()->user()->managers()->first()->provider_id;
        $orders = Order::where('provider_id', $provider_id)->get();
        $ordersNew = 0;
        $ordersOffers = [];
        foreach ($orders as $item) {
            if($item->status === OrderStatusEnum::new->name){
                $ordersNew++;
            }
            if(isset($ordersOffers[$item->status][$item->offer_id])){
                $ordersOffers[$item->status][$item->offer_id] += 1;
            } else {
                $ordersOffers[$item->status][$item->offer_id] = 1;
            }

        }
        return [
            'orders_offers'=>$ordersOffers,
            'top'=>[
                'orders-new'=>$ordersNew,
            ]
        ];
    }
}
