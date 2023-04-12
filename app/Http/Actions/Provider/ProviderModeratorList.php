<?php

namespace App\Http\Actions\Provider;

use App\Http\Actions\ActionInterface;
use App\Models\Provider;
use Illuminate\Support\Collection;

class ProviderModeratorList implements ActionInterface
{
    public function execute(array $data): Collection|array
    {
        return Provider::where('status', $data['status'])->get();
    }
}
