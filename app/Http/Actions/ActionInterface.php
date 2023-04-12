<?php

namespace App\Http\Actions;

use Illuminate\Database\Eloquent\Collection;

interface ActionInterface
{
    public function execute(array $data);
}
