<?php

namespace App\Http\Controllers;

use App\Actions\Profile\UpdatePasswordAction;
use App\Actions\Profile\UpdateProfileAction;
use App\Http\Requests\Profile\UpdateAvatarRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('dashboard.profile.index', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request, UpdateProfileAction $action): JsonResponse
    {
        $action->execute(auth()->user(), $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ]);
    }

    public function updateAvatar(UpdateAvatarRequest $request, UpdateProfileAction $action): JsonResponse
    {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user = $action->updateAvatar(auth()->user(), $path);

        return response()->json([
            'success' => true,
            'message' => 'Photo updated successfully.',
            'avatar_url' => $user->avatar_url,
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request, UpdatePasswordAction $action): JsonResponse
    {
        $action->execute(auth()->user(), $request->validated()['password']);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}
