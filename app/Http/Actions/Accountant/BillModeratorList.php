<?php

namespace App\Http\Actions\Accountant;

use App\Http\Actions\ActionInterface;
use App\Models\Bill;
use App\Models\Provider;
use Illuminate\Support\Collection;

class BillModeratorList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        return Bill::where('status', $data['status'])->get();
    }
}
