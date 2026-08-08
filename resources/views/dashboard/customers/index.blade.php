@extends('layouts.app')

@section('title', 'Customers')

@section('content')

    <div class="flex items-center justify-between mb-3">

        <h1 class="text-2xl font-bold text-gray-800">Customers</h1>

        <a href="{{ route('customers.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i>
            Add Customer
        </a>

    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-6">

        <form method="GET" action="{{ route('customers.index') }}" class="flex gap-3">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name or phone..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-lg">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if (request('search'))
                <a href="{{ route('customers.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg">
                    Clear
                </a>
            @endif

        </form>

    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Code</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Phone</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $customer->customer_code }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $customer->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $customer->phone }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $customer->address ?? '-' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('customers.show', $customer->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                View <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                            No customers found.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">
        {{ $customers->links() }}
    </div>

@endsection
