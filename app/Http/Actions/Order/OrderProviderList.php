<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OfferStatusEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Support\Collection;

class OrderProviderList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        $orderBy = 'updated_at';
        $direction = 'desc';
        if (in_array($data['status'], [
            OrderStatusEnum::new->name,
            OrderStatusEnum::in_progress->name,
            OrderStatusEnum::postpone->name,
        ])) {
            $direction = 'asc';
        }
        if ($data['status'] == OrderStatusEnum::in_progress->name) {
            $orderBy = 'created_at';
        }
        if ($data['status'] == OrderStatusEnum::in_progress->name) {
            if (isset($data['direction'])) {
                $direction = $data['direction'] === 'desc' ? 'desc' : 'asc';
            }
        }
        $manager = auth()->user()->managers()->first();
        $provider_id = $manager?->provider_id;
        if ($manager && $manager->owner) {
            return Order::where('status', $data['status'])
                ->where('provider_id', $provider_id)
                ->where('offer_id', $data['offer'])
                ->orderBy($orderBy, $direction)->get();
        }
        return Order::where('status', $data['status'])
            ->where('manager_id', $manager->id)
            ->where('provider_id', $provider_id)
            ->where('offer_id', $data['offer'])
            ->orderBy($orderBy, $direction)->get();
    }
}
