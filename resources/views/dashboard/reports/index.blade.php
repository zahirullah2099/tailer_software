@extends('layouts.app')

@section('title', 'Reports')

@push('styles')
<style>[x-cloak] { display: none !important; }</style>
@endpush

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Reports</h1>
        <p class="text-sm text-gray-500 mt-1">Business performance overview.</p>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-end gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                <input type="date" name="from" value="{{ $from->format('Y-m-d') }}"
                       class="border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                <input type="date" name="to" value="{{ $to->format('Y-m-d') }}"
                       class="border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                Apply
            </button>

            <p class="text-sm text-gray-400 ml-auto self-center">
                Revenue and status charts reflect this range. Outstanding Dues and Top Customers are always current.
            </p>

        </form>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-dashboard.card title="Revenue (Selected Range)" value="Rs. {{ number_format($totalRevenue, 2) }}" icon="money-bill-trend-up" color="green" />
        <x-dashboard.card title="Orders (Selected Range)" value="{{ $totalOrders }}" icon="file-invoice" color="blue" />
        <x-dashboard.card title="Total Outstanding Dues" value="Rs. {{ number_format($totalOutstanding, 2) }}" icon="triangle-exclamation" color="red" />
    </div>

    <!-- Charts -->
    @php
        $statusChartData = $statusCounts->map(fn ($row) => [
            'label' => ucfirst($row->status->value),
            'total' => $row->total,
        ]);

        $dressTypeChartData = $dressTypeCounts->map(fn ($row) => [
            'label' => ucwords(str_replace('_', ' ', $row->dress_type->value)),
            'total' => $row->total,
        ]);
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Revenue Over Time</h3>
            <div style="position: relative; height: 260px;">
                <canvas id="revenueChart" data-chart='@json($revenue)'></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Orders by Status</h3>
            <div style="position: relative; height: 260px;">
                <canvas id="statusChart" data-chart='@json($statusChartData)'></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Orders by Dress Type</h3>
            <div style="position: relative; height: 220px;">
                <canvas id="dressTypeChart" data-chart='@json($dressTypeChartData)'></canvas>
            </div>
        </div>

    </div>

    <!-- Outstanding Dues -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Outstanding Dues</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-600">
                        <th class="px-6 py-3 font-semibold">Order #</th>
                        <th class="px-6 py-3 font-semibold">Customer</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                        <th class="px-6 py-3 font-semibold">Paid</th>
                        <th class="px-6 py-3 font-semibold">Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($outstandingDues as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium">
                                <a href="{{ route('customers.show', $order->customer_id) }}" class="text-blue-600 hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-6 py-3">{{ $order->customer->name }}</td>
                            <td class="px-6 py-3">Rs. {{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-3 text-green-700">Rs. {{ number_format($order->payments_sum_amount ?? 0, 2) }}</td>
                            <td class="px-6 py-3 text-red-600 font-medium">Rs. {{ number_format($order->balance, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">No outstanding dues. Everyone's paid up.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Top Customers -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Top Customers</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-600">
                        <th class="px-6 py-3 font-semibold">Customer</th>
                        <th class="px-6 py-3 font-semibold">Phone</th>
                        <th class="px-6 py-3 font-semibold">Orders</th>
                        <th class="px-6 py-3 font-semibold">Total Spend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($topCustomers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium">
                                <a href="{{ route('customers.show', $customer->id) }}" class="text-blue-600 hover:underline">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td class="px-6 py-3">{{ $customer->phone }}</td>
                            <td class="px-6 py-3">{{ $customer->orders_count }}</td>
                            <td class="px-6 py-3">Rs. {{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">No customer orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/reports/index.js') }}"></script>
@endpush
