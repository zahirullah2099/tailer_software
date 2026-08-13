@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="max-w-2xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>

    {{-- Profile Info --}}
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">

        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Account Information</h2>

        <div id="profileAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <form id="profileForm" data-url="{{ route('profile.update') }}">
            @csrf

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="name"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <input type="text" name="phone" value="{{ $user->phone }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email (optional)</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="email"></p>
                </div>

                <div class="text-sm text-gray-500">
                    <span class="text-gray-400">Last login:</span>
                    {{ $user->last_login_at?->format('d M, Y h:i A') ?? 'N/A' }}
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" id="profileSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">

        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Change Password</h2>

        <div id="passwordAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <form id="passwordForm" data-url="{{ route('profile.password') }}">
            @csrf

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Password *</label>
                    <input type="password" name="current_password"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="current_password"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password *</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="password"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password *</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" id="passwordSubmitBtn"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-lock"></i>
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
