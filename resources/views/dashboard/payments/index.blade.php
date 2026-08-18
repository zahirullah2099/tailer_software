@extends('layouts.app')

@section('title', 'Payments')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">Payments</h1>
            <p class="text-sm text-gray-500 mt-1">All payments recorded across every order.</p>
        </div>

    </div>

    <!-- Search -->
    <div class="flex items-center gap-3">
        <input
            type="text"
            id="customSearch"
            placeholder="Search by order # or customer..."
            class="flex-1 max-w-md border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-2">

        <div class="overflow-x-auto">

            <table id="paymentsTable" class="min-w-full text-sm">

                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-600">
                        <th class="px-6 py-4 font-semibold">Order #</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Amount</th>
                        <th class="px-6 py-4 font-semibold">Method</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                        <th class="px-6 py-4 font-semibold">Received By</th>
                        <th class="px-6 py-4 font-semibold">Remarks</th>
                        <th class="px-6 py-4 font-semibold text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($payments as $payment)

                        <tr data-payment-row="{{ $payment->id }}" class="border-t hover:bg-gray-50">

                            <td class="px-6 py-4 font-medium">{{ $payment->order?->order_number ?? '—' }}</td>

                            <td class="px-6 py-4">
                                <div>{{ $payment->order?->customer?->name ?? '—' }}</div>
                                <div class="text-xs text-gray-400">{{ $payment->order?->customer?->phone ?? '' }}</div>
                            </td>

                            <td class="px-6 py-4 text-green-700 font-medium">Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4">{{ ucfirst($payment->payment_method->value) }}</td>
                            <td class="px-6 py-4">{{ $payment->paid_at->format('d M, Y') }}</td>
                            <td class="px-6 py-4">{{ $payment->receiver->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $payment->remarks ?? '-' }}</td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    @include('dashboard.payments._actions')
                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                No payments recorded yet.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/payments/index.js') }}"></script>
@endpush
