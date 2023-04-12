<?php

namespace App\Http\Actions\Accountant;

use App\Http\Actions\ActionInterface;
use App\Models\Bill;
use App\Models\Enums\BillStatusEnum;

class BillPayed implements ActionInterface
{
    public function execute(array $data): void
    {
        $bill = Bill::find($data['id']);
        $bill->status = BillStatusEnum::payed->name;
        $bill->updated_at = date('Y-m-d H:i:s');
        $bill->used_date = date('Y-m-d H:i:s');
        $bill->save();
    }
}
