@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
        <p class="text-sm text-gray-500 mt-1">Manage your account information and security.</p>
    </div>

    <!-- Avatar Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <div class="flex items-center gap-6">

            <!-- Avatar Preview -->
            <div class="relative group">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-blue-600 flex items-center justify-center shadow-md">
                    @if ($user->avatar)
                        <img id="avatarPreview" src="{{ $user->avatar_url }}"
                             alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-user text-white text-3xl" id="avatarIconFallback"></i>
                        <img id="avatarPreview" src="" alt="Avatar"
                             class="w-full h-full object-cover hidden">
                    @endif
                </div>

                <label for="avatarInput"
                       class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition">
                    <i class="fa-solid fa-camera text-white text-lg"></i>
                </label>

                <input type="file" id="avatarInput" accept="image/*" class="hidden"
                       data-url="{{ route('profile.avatar') }}">
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->phone }}</p>
                <p class="text-xs text-gray-400 mt-2">
                    Click the photo to upload a new one (max 2MB, JPG/PNG/WebP)
                </p>
                <p id="avatarMsg" class="text-xs mt-1 hidden"></p>
            </div>

        </div>

    </div>

    <!-- Account Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-base font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">
            Account Information
        </h2>

        <div id="profileAlertBox" class="hidden mb-5 px-4 py-3 rounded-xl text-sm font-medium"></div>

        <form id="profileForm" data-url="{{ route('profile.update') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name *</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-white
                                  outline-none transition-colors focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="name"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone *</label>
                    <input type="text" name="phone" value="{{ $user->phone }}"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-white
                                  outline-none transition-colors focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="phone"></p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email (optional)</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-white
                                  outline-none transition-colors focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="email"></p>
                </div>

            </div>

            <div class="flex items-center justify-between pt-2">
                <p class="text-xs text-gray-400">
                    <i class="fa-solid fa-clock mr-1"></i>
                    Last login: {{ $user->last_login_at?->format('d M, Y h:i A') ?? 'N/A' }}
                </p>
                <button type="submit" id="profileSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

    <!-- Change Password -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-base font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">
            Change Password
        </h2>

        <div id="passwordAlertBox" class="hidden mb-5 px-4 py-3 rounded-xl text-sm font-medium"></div>

        <form id="passwordForm" data-url="{{ route('profile.password') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password *</label>
                    <input type="password" name="current_password"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-white
                                  outline-none transition-colors focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="current_password"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password *</label>
                    <input type="password" name="password"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-white
                                  outline-none transition-colors focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="password"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password *</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-2.5 text-sm bg-white
                                  outline-none transition-colors focus:border-blue-600 focus:ring-4 focus:ring-blue-500/10">
                </div>

            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" id="passwordSubmitBtn"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-lock mr-1.5"></i>
                    Change Password
                </button>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/profile/index.js') }}"></script>
@endpush
