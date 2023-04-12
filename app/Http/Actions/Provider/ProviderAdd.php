<?php

namespace App\Http\Actions\Provider;

use App\Http\Actions\ActionInterface;
use App\Models\Enums\ProviderStatusEnum;
use App\Models\Enums\UserGroupCodeEnum;
use App\Models\Provider;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProviderAdd implements ActionInterface
{
    public function execute(array $data): void
    {
        $data['status'] = ProviderStatusEnum::active->name;
        $data['api_key'] = Str::uuid();
        $provider = Provider::create($data);
        $user = User::create([
            'name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'second_name' => $data['second_name'],
            'email' => $data['email'],
            'password' => Hash::make(Str::uuid()),
            'phone' => $data['phone'],
            'login' => str_replace(['-','_','','+','(',')'], '', $data['phone']),
        ]);
        $group = UserGroup::where('code', UserGroupCodeEnum::provider->name)->first();
        $user->groups()->attach($group->id);
        $provider->managers()->create([
            'owner' => 1,
            'user_id' => $user->id,
        ]);
    }
}
