<?php

namespace App\Actions\Profile;

use App\Models\User;

class UpdateProfileAction
{
    public function execute(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
        ]);

        return $user->fresh();
    }
}
