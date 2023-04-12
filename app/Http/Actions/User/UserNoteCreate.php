<?php

namespace App\Http\Actions\User;

use App\Http\Actions\ActionInterface;
use App\Models\UserNote;

class UserNoteCreate implements ActionInterface
{
    public function execute(array $data): UserNote
    {
        $data['user_create_id'] = auth()->id();
        return UserNote::create($data);
    }
}
