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
                <button type="button" id="measurementBtn"
                        data-customer-id="{{ $customer->id }}"
                        class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2.5 rounded-lg">
                    <i class="fa-solid fa-ruler"></i>
                    <span id="measurementBtnLabel">
                        {{ $customer->measurements->isNotEmpty() ? 'Edit Measurement' : 'Add Measurement' }}
                    </span>
                </button>

                <a href="{{ route('orders.create', ['customer' => $customer->id]) }}"
                   class="w-full block text-center bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2.5 rounded-lg">
                    <i class="fa-solid fa-file-invoice"></i> New Order
                </a>
            </div>

        </div>

        <!-- Measurements -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md border border-gray-100 p-6">

            <h3 class="text-lg font-semibold text-gray-800 mb-4">Measurements</h3>

            <div id="measurementCard">
                @include('dashboard.customers._measurement-card', ['measurement' => $customer->measurements->first()])
            </div>

            <h3 class="text-lg font-semibold text-gray-800 mt-8 mb-4">Order History</h3>

            @forelse ($customer->orders as $order)

                @php
                    $statusStyles = match ($order->status) {
                        \App\Enums\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700',
                        \App\Enums\OrderStatus::CUTTING,
                        \App\Enums\OrderStatus::STITCHING,
                        \App\Enums\OrderStatus::IRONING => 'bg-blue-100 text-blue-700',
                        \App\Enums\OrderStatus::READY => 'bg-purple-100 text-purple-700',
                        \App\Enums\OrderStatus::DELIVERED => 'bg-green-100 text-green-700',
                        \App\Enums\OrderStatus::CANCELLED => 'bg-red-100 text-red-700',
                    };
                @endphp

                <div class="border border-gray-100 rounded-lg p-4 mb-3 last:mb-0">

                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-800">{{ $order->order_number }}</span>

                        <span class="text-xs px-2 py-1 rounded-full {{ $statusStyles }}">
                            {{ ucfirst($order->status->value) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div><span class="text-gray-400">Dress:</span> {{ ucwords(str_replace('_', ' ', $order->dress_type->value)) }}</div>
                        <div><span class="text-gray-400">Qty:</span> {{ $order->quantity }}</div>
                        <div><span class="text-gray-400">Amount:</span> Rs. {{ number_format($order->total_amount, 2) }}</div>
                        <div><span class="text-gray-400">Order Date:</span> {{ $order->order_date->format('d M, Y') }}</div>
                    </div>

                    @if ($order->delivery_date)
                        <div class="text-sm text-gray-500 mt-2">
                            <span class="text-gray-400">Expected Delivery:</span> {{ $order->delivery_date->format('d M, Y') }}
                        </div>
                    @endif

                    @if ($order->notes)
                        <p class="text-sm text-gray-500 mt-2">
                            <span class="text-gray-400">Notes:</span> {{ $order->notes }}
                        </p>
                    @endif

                </div>

            @empty
                <p class="text-gray-400 text-sm">No orders yet.</p>
            @endforelse

        </div>

    </div>

    <!-- Add / Edit Measurement Modal -->
    <div id="measurementModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800" id="measurementModalTitle">Measurement</h2>
                <button type="button" id="closeMeasurementModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div id="measurementAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

            <form id="measurementForm"
                  data-customer-id="{{ $customer->id }}"
                  data-store-url="{{ route('customers.measurement.store', $customer->id) }}"
                  data-edit-url="{{ route('customers.measurement.edit', $customer->id) }}">
                @csrf

                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Shirt</h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-6">

                    @foreach (['chest' => 'Chest', 'shoulder' => 'Shoulder', 'sleeve' => 'Sleeve', 'neck' => 'Neck', 'shirt_length' => 'Shirt Length'] as $field => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                            <input type="number" step="0.01" name="{{ $field }}" id="m_{{ $field }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-red-600 text-sm mt-1 field-error" data-field="{{ $field }}"></p>
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Collar</label>
                        <select name="collar" id="m_collar" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select --</option>
                            @foreach (\App\Enums\CollarType::cases() as $case)
                                <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm mt-1 field-error" data-field="collar"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cuff</label>
                        <select name="cuff" id="m_cuff" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select --</option>
                            @foreach (\App\Enums\CuffType::cases() as $case)
                                <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm mt-1 field-error" data-field="cuff"></p>
                    </div>

                </div>

                <h3 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Shalwar</h3>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-6">

                    @foreach (['waist' => 'Waist', 'hip' => 'Hip', 'shalwar_length' => 'Shalwar Length', 'bottom_width' => 'Bottom Width'] as $field => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                            <input type="number" step="0.01" name="{{ $field }}" id="m_{{ $field }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-red-600 text-sm mt-1 field-error" data-field="{{ $field }}"></p>
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pocket Type</label>
                        <select name="pocket_type" id="m_pocket_type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select --</option>
                            @foreach (\App\Enums\PocketType::cases() as $case)
                                <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm mt-1 field-error" data-field="pocket_type"></p>
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fitting Notes</label>
                    <textarea name="fitting_notes" id="m_fitting_notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="fitting_notes"></p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="cancelMeasurementBtn"
                            class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" id="measurementSubmitBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Measurement
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('js/customers/measurement.js') }}"></script>
@endpush
