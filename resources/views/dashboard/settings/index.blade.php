@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Settings</h1>
        <p class="text-sm text-gray-500 mt-1">Configure your shop information.</p>
    </div>

    <!-- Logo Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-base font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">
            Shop Logo
        </h2>

        <div class="flex items-center gap-6">

            <div class="relative group">
                <div class="w-24 h-24 rounded-2xl overflow-hidden bg-blue-600 flex items-center justify-center shadow-md">
                    @if ($settings['shop_logo'])
                        <img id="logoPreview" src="{{ asset('storage/' . $settings['shop_logo']) }}"
                             alt="Logo" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-scissors text-white text-3xl" id="logoIconFallback"></i>
                        <img id="logoPreview" src="" alt="Logo"
                             class="w-full h-full object-cover hidden">
                    @endif
                </div>

                <label for="logoInput"
                       class="absolute inset-0 rounded-2xl bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition">
                    <i class="fa-solid fa-camera text-white text-lg"></i>
                </label>

                <input type="file" id="logoInput" accept="image/*" class="hidden">
            </div>

            <div>
                <p class="text-sm font-medium text-gray-700">Upload your shop logo</p>
                <p class="text-xs text-gray-400 mt-1">Max 2MB · JPG, PNG, WebP, SVG</p>
                <p class="text-xs text-gray-400">Click the logo to change it.</p>
                <p id="logoMsg" class="text-xs mt-2 hidden"></p>
            </div>

        </div>

    </div>

    <!-- Shop Info -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-base font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">
            Shop Information
        </h2>

        <div id="settingsAlertBox" class="hidden mb-5 px-4 py-3 rounded-xl text-sm font-medium"></div>

        <form id="settingsForm" data-url="{{ route('settings.update') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Shop Name *</label>
                    <input type="text" name="shop_name" value="{{ $settings['shop_name'] }}"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                  focus:outline-none focus:border-blue-500 transition-colors">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="shop_name"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                    <input type="text" name="shop_phone" value="{{ $settings['shop_phone'] }}"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                  focus:outline-none focus:border-blue-500 transition-colors">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="shop_phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="shop_email" value="{{ $settings['shop_email'] }}"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                  focus:outline-none focus:border-blue-500 transition-colors">
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="shop_email"></p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label>
                    <textarea name="shop_address" rows="2"
                              class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                     focus:outline-none focus:border-blue-500 transition-colors resize-none">{{ $settings['shop_address'] }}</textarea>
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="shop_address"></p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea name="shop_description" rows="3"
                              class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm
                                     focus:outline-none focus:border-blue-500 transition-colors resize-none">{{ $settings['shop_description'] }}</textarea>
                    <p class="text-red-500 text-xs mt-1 field-error" data-field="shop_description"></p>
                </div>

            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" id="settingsSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i>
                    Save Settings
                </button>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/settings/index.js') }}"></script>
@endpush
