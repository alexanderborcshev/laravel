<?php

namespace App\Http\Actions\Accountant;

use App\Http\Actions\ActionInterface;
use App\Models\Bill;
use App\Models\Provider;
use Illuminate\Support\Collection;

class BillProviderList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        $provider_id = auth()->user()->managers()->first()->provider_id;
        return Bill::where('provider_id', $provider_id)->get();
    }
}
