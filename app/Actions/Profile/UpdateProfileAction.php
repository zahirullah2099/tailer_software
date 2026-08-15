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

    public function updateAvatar(User $user, string $path): User
    {
        // Delete old avatar file if exists
        if ($user->avatar) {
            \Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $path]);

        return $user->fresh();
    }
}
