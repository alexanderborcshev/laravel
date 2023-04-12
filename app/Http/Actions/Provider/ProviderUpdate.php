<?php

namespace App\Http\Actions\Provider;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Enums\OrderStatusEnum;
use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Order;
use App\Models\OrderEvent;
use App\Models\Provider;
use App\Models\UserGroup;

class ProviderUpdate implements ActionInterface
{
    public function execute(array $data): void
    {
        $provider = Provider::find($data['id']);
        $data['contract_date'] = date('Y-m-d H:i:s', strtotime($data['contract_date']));
        $provider->update($data);

        $provider->managers()->where('owner', 1)->first()->user()->update([
            'name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'second_name' => $data['second_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'login' => str_replace(['-','_','','+','(',')'], '', $data['phone']),
        ]);
    }
}
