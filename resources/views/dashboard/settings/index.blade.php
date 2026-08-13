@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="max-w-2xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Settings</h1>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">

        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Shop Information</h2>

        <div id="settingsAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <form id="settingsForm" data-url="{{ route('settings.update') }}">
            @csrf

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shop Name *</label>
                    <input type="text" name="shop_name" value="{{ $settings['shop_name'] }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="shop_name"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="shop_phone" value="{{ $settings['shop_phone'] }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="shop_phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="shop_email" value="{{ $settings['shop_email'] }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="shop_email"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="shop_address" rows="2"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $settings['shop_address'] }}</textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="shop_address"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="shop_description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $settings['shop_description'] }}</textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="shop_description"></p>
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" id="settingsSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
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
