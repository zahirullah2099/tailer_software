<?php

namespace App\Actions\Profile;

use App\Models\User;

class UpdatePasswordAction
{
    public function execute(User $user, string $newPassword): void
    {
        $user->update(['password' => $newPassword]);
    }
}
