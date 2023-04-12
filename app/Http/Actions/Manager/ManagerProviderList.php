<?php

namespace App\Http\Actions\Manager;

use App\Http\Actions\ActionInterface;
use App\Models\Manager;

class ManagerProviderList implements ActionInterface
{
    public function execute(array $data)
    {
        $provider_id = auth()->user()->managers()->first()->provider_id;
        return Manager::where('provider_id', $provider_id)->get();
    }
}
