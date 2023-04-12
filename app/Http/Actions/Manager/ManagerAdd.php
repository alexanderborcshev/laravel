<?php

namespace App\Http\Actions\Manager;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Manager;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerAdd implements ActionInterface
{
    public function execute(array $data)
    {
        $provider_id = auth()->user()->managers()->first()->provider_id;
        $data['password'] = Hash::make(Str::uuid());
        $user = User::create($data);
        $group = UserGroup::where('code', UserGroupCodeEnum::provider->name)->first();
        $user->groups()->attach($group->id);
        return Manager::create([
            'provider_id' => $provider_id,
            'user_id' => $user->id,
        ]);
    }
}
