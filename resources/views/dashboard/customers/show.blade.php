@extends('layouts.app')

@section('title', $customer->name)

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Customer Profile</h1>

        <a href="{{ route('customers.index') }}" class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i> Back to Customers
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Customer Info Card -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-md border border-gray-100 p-6">

            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                <i class="fa-solid fa-user text-blue-600 text-2xl"></i>
            </div>

            <h2 class="text-xl font-bold text-gray-800">{{ $customer->name }}</h2>
            <p class="text-gray-400 text-sm mb-4">{{ $customer->customer_code }}</p>

            <div class="space-y-3 text-sm">

                <div class="flex items-center gap-3 text-gray-600">
                    <i class="fa-solid fa-phone w-5 text-gray-400"></i>
                    {{ $customer->phone }}
                </div>

                @if ($customer->alternate_phone)
                    <div class="flex items-center gap-3 text-gray-600">
                        <i class="fa-solid fa-phone-flip w-5 text-gray-400"></i>
                        {{ $customer->alternate_phone }}
                    </div>
                @endif

                @if ($customer->address)
                    <div class="flex items-start gap-3 text-gray-600">
                        <i class="fa-solid fa-location-dot w-5 text-gray-400 mt-0.5"></i>
                        {{ $customer->address }}
                    </div>
                @endif

                @if ($customer->notes)
                    <div class="flex items-start gap-3 text-gray-600">
                        <i class="fa-solid fa-note-sticky w-5 text-gray-400 mt-0.5"></i>
                        {{ $customer->notes }}
                    </div>
                @endif

            </div>

            <div class="mt-6 flex flex-col gap-2">
                <button type="button" disabled
                        class="w-full bg-gray-100 text-gray-400 px-4 py-2.5 rounded-lg cursor-not-allowed">
                    <i class="fa-solid fa-ruler"></i> Add Measurement (coming soon)
                </button>

                <button type="button" disabled
                        class="w-full bg-gray-100 text-gray-400 px-4 py-2.5 rounded-lg cursor-not-allowed">
                    <i class="fa-solid fa-file-invoice"></i> New Order (coming soon)
                </button>
            </div>

        </div>

        <!-- Measurements -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md border border-gray-100 p-6">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">Measurements</h3>

            @forelse ($customer->measurements as $measurement)

                <div class="border border-gray-100 rounded-lg p-4 mb-4 last:mb-0">

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-400">
                            Taken on {{ $measurement->created_at->format('d M, Y') }}
                        </span>

                        @if ($measurement->is_default)
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Default</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div><span class="text-gray-400">Chest:</span> {{ $measurement->chest ?? '-' }}</div>
                        <div><span class="text-gray-400">Shoulder:</span> {{ $measurement->shoulder ?? '-' }}</div>
                        <div><span class="text-gray-400">Sleeve:</span> {{ $measurement->sleeve ?? '-' }}</div>
                        <div><span class="text-gray-400">Neck:</span> {{ $measurement->neck ?? '-' }}</div>
                        <div><span class="text-gray-400">Shirt Length:</span> {{ $measurement->shirt_length ?? '-' }}</div>
                        <div><span class="text-gray-400">Waist:</span> {{ $measurement->waist ?? '-' }}</div>
                        <div><span class="text-gray-400">Hip:</span> {{ $measurement->hip ?? '-' }}</div>
                        <div><span class="text-gray-400">Shalwar Length:</span> {{ $measurement->shalwar_length ?? '-' }}</div>
                        <div><span class="text-gray-400">Bottom Width:</span> {{ $measurement->bottom_width ?? '-' }}</div>
                        <div><span class="text-gray-400">Collar:</span> {{ $measurement->collar?->value ?? '-' }}</div>
                        <div><span class="text-gray-400">Cuff:</span> {{ $measurement->cuff?->value ?? '-' }}</div>
                        <div><span class="text-gray-400">Pocket:</span> {{ $measurement->pocket_type?->value ?? '-' }}</div>
                    </div>

                    @if ($measurement->fitting_notes)
                        <p class="text-sm text-gray-500 mt-3">
                            <span class="text-gray-400">Notes:</span> {{ $measurement->fitting_notes }}
                        </p>
                    @endif

                </div>

            @empty
                <p class="text-gray-400 text-sm">No measurements recorded yet.</p>
            @endforelse

            <h3 class="text-lg font-semibold text-gray-800 mt-8 mb-4">Order History</h3>
            <p class="text-gray-400 text-sm">Orders module coming soon.</p>

        </div>

    </div>

@endsection
