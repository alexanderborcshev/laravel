<?php

namespace App\Http\Actions\User;

use App\Http\Actions\ActionInterface;
use App\Models\UserNote;
use Illuminate\Support\Facades\Auth;

class UserRule implements ActionInterface
{
    public function execute(array $data): void
    {
        $manager = Auth::user()->managers()->first();
        $manager->rule = true;
        $manager->save();
    }
}
