<?php

namespace App\Http\Actions\Manager;

use App\Http\Actions\ActionInterface;
use App\Models\Manager;

class ManagerUpdate implements ActionInterface
{
    public function execute(array $data)
    {
        $manager = Manager::find($data['id']);
        if(!$manager->user->blocked){
            $manager->user()->update($data);
        }
        return $manager;
    }
}
