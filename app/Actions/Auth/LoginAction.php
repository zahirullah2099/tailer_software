<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginAction
{
    public function execute(array $credentials, Request $request): bool
    {
        if (! Auth::attempt($credentials)) {
            return false;
        }

        $request->session()->regenerate();

        return true;
    }
}
