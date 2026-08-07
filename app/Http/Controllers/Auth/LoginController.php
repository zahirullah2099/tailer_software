<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(
        LoginRequest $request,
        LoginAction $loginAction
    ): RedirectResponse {

        $credentials = $request->validated();

        if (! $loginAction->execute($credentials, $request)) {
            return back()
                ->withErrors([
                    'phone' => 'Invalid phone number or password.',
                ])
                ->onlyInput('phone');
        }

        return redirect()->route('dashboard');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
