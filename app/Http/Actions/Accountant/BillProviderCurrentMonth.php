<?php

namespace App\Http\Actions\Accountant;

use App\Http\Actions\ActionInterface;
use App\Http\Resources\Api\Order\OrderForBillResource;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BillProviderCurrentMonth implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        $provider_id = auth()->user()->managers()->first()->provider_id;
        $orders = Order::where('provider_id', $provider_id)
            ->where('status', OrderStatusEnum::finished->name)
            ->whereNot('bill_id','>', 0 )
            ->get();
        $sum = 0;
        foreach ($orders as $item) {
            $sum += $item->price * $item->commission / 100;
        }
        return [
            'provider_id' => $provider_id,
            'orders' => OrderForBillResource::collection($orders),
            'created_date_text' => (new Carbon(now()))->translatedFormat('F Y'),
            'sum' => $sum,
            'id' => 'current',
        ];
    }
}

