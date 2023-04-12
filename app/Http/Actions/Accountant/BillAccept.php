<?php

namespace App\Http\Actions\Accountant;

use App\Http\Actions\ActionInterface;
use App\Models\Bill;

class BillAccept implements ActionInterface
{
    public function execute(array $data): void
    {
        $bill = Bill::find($data['id']);
        $bill->updated_at = date('Y-m-d H:i:s');
        $bill->accept_date = date('Y-m-d H:i:s');
        $bill->accept_user_id = Auth()->user()->id;
        $bill->save();
    }
}
