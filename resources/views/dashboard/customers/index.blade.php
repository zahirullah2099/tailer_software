@extends('layouts.app')

@section('title', 'Customers')

@section('content')

    <div class="flex items-center justify-between gap-4 mb-4">

        <h1 class="text-2xl font-bold text-gray-800 whitespace-nowrap">Customers</h1>

        <form method="GET" action="{{ route('customers.index') }}" class="flex-1 flex gap-2 max-w-md">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name or phone..."
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            @if (request('search'))
                <a href="{{ route('customers.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif

        </form>

        <a href="{{ route('customers.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-user-plus"></i>
            Add Customer
        </a>

    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <table class="w-full text-left text-sm">

            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-2.5 font-semibold text-gray-600">Code</th>
                    <th class="px-4 py-2.5 font-semibold text-gray-600">Name</th>
                    <th class="px-4 py-2.5 font-semibold text-gray-600">Phone</th>
                    <th class="px-4 py-2.5 font-semibold text-gray-600">Address</th>
                    <th class="px-4 py-2.5 font-semibold text-gray-600 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5 text-gray-500">{{ $customer->customer_code }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-800">{{ $customer->name }}</td>
                        <td class="px-4 py-2.5 text-gray-600">{{ $customer->phone }}</td>
                        <td class="px-4 py-2.5 text-gray-600">{{ $customer->address ?? '-' }}</td>
                        <td class="px-4 py-2.5">
                            <div class="flex justify-end gap-2">

                                <a href="{{ route('customers.show', $customer->id) }}"
                                   title="View"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>

                                {{-- Edit route not built yet --}}
                                <a href="#"
                                   title="Edit (coming soon)"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-50 text-green-600 hover:bg-green-100">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>

                                {{-- Delete route not built yet --}}
                                <button type="button"
                                        title="Delete (coming soon)"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400">
                            No customers found.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">
        {{ $customers->withQueryString()->links() }}
    </div>

@endsection