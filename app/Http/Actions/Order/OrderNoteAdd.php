<?php

namespace App\Http\Actions\Order;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\OrderEventEnum;
use App\Models\Order;
use App\Models\OrderEvent;

class OrderNoteAdd implements ActionInterface
{
    public function execute(array $data): OrderEvent
    {
        $data['user_id'] = auth()->id();
        $data['code'] = OrderEventEnum::note->name;
        return OrderEvent::create($data);
    }
}
