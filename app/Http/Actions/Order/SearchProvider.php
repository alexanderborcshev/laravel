<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Order;
use Illuminate\Support\Collection;

class SearchProvider implements ActionInterface
{
    public function execute(array $data = []): Collection|array
    {
        $provider_id = auth()->user()->managers()->first()->provider_id;
        $phone  = str_replace(['-','_','','+','(',')'], '', $data['query']);
        return Order::where('phone','LIKE', $phone.'%')->where('provider_id', $provider_id)->limit(100)->get();
    }
}
