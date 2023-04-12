<?php

namespace App\Http\Actions\Manager;

use App\Http\Actions\ActionInterface;
use App\Models\Manager;

class ManagerBlock implements ActionInterface
{
    public function execute(array $data)
    {
        $manager = Manager::find($data['id']);
        $manager->user()->update([
            'blocked' => 1,
            'blocked_date' => date('Y-m-d H:i:s'),
        ]);
        return $manager;
    }
}
