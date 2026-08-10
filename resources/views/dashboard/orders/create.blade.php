@extends('layouts.app')

@section('title', 'New Order')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">New Order</h1>

        <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Step 1: Customer -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">

        <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">Customer</h2>

        <div id="customerSearchStep" class="{{ $customer ? 'hidden' : '' }}">
            <input
                type="text"
                id="orderCustomerSearch"
                placeholder="Search customer by name or phone..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <div id="orderCustomerResults" class="mt-3 space-y-2"></div>
        </div>

        <div id="selectedCustomerCard" class="{{ $customer ? '' : 'hidden' }}">

            <div class="flex items-center justify-between border border-gray-100 rounded-lg p-4">

                <div>
                    <p class="font-medium text-gray-800" id="selectedCustomerName">
                        {{ $customer?->name }}
                    </p>
                    <p class="text-sm text-gray-500" id="selectedCustomerMeta">
                        {{ $customer?->customer_code }} &middot; {{ $customer?->phone }}
                    </p>
                </div>

                <button type="button" id="changeCustomerBtn"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Change
                </button>

            </div>

            <div id="noMeasurementWarning"
                 class="{{ $customer && $customer->measurements->isEmpty() ? '' : 'hidden' }} mt-3 bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm rounded-lg px-4 py-3 flex items-center justify-between gap-3">
                <span>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    This customer has no measurement yet. An order can't be created without one.
                </span>
                <a id="addMeasurementLink" href="{{ $customer ? route('customers.show', $customer->id) : '#' }}"
                   class="whitespace-nowrap font-medium underline">
                    Add Measurement
                </a>
            </div>

        </div>

    </div>

    <!-- Step 2: Order Details -->
    <div id="orderDetailsCard"
         class="bg-white rounded-xl shadow-md border border-gray-100 p-6 {{ ($customer && $customer->measurements->isNotEmpty()) ? '' : 'hidden' }}">

        <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Order Details</h2>

        <div id="orderAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <form id="orderForm" data-store-url="{{ route('orders.store') }}">
            @csrf

            <input type="hidden" name="customer_id" id="order_customer_id"
                   value="{{ $customer?->id }}">
            <input type="hidden" name="measurement_id" id="order_measurement_id"
                   value="{{ $customer?->measurements->first()?->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dress Type *</label>
                    <select name="dress_type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select --</option>
                        @foreach (\App\Enums\DressType::cases() as $case)
                            <option value="{{ $case->value }}">{{ ucwords(str_replace('_', ' ', $case->value)) }}</option>
                        @endforeach
                    </select>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="dress_type"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                    <input type="number" name="quantity" min="1" value="1"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="quantity"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount (Rs.) *</label>
                    <input type="number" step="0.01" name="total_amount"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="total_amount"></p>
                </div>

                <div></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Date *</label>
                    <input type="date" name="order_date" value="{{ now()->format('Y-m-d') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="order_date"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Date</label>
                    <input type="date" name="delivery_date"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="delivery_date"></p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="notes"></p>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ url()->previous() }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" id="orderSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Create Order
                </button>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/orders/create.js') }}"></script>
@endpush
