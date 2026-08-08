@extends('layouts.app')

@section('title', 'Customers')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Customers
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                View and manage all registered customers.
            </p>
        </div>

        <a href="{{ route('customers.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow">

            <i class="fa-solid fa-user-plus"></i>

            <span>Add Customer</span>

        </a>

    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-2"> 

        <!-- Table -->
        <div class="overflow-x-auto">

            <table id="customersTable" class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr class="text-left text-gray-600">

                        <th class="px-6 py-4 font-semibold">
                            Customer Code
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Name
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Phone
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Address
                        </th>

                        <th class="px-6 py-4 font-semibold text-center">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($customers as $customer)

                        <tr class="border-t hover:bg-gray-50">

                            <td class="px-6 py-4 font-medium">
                                {{ $customer->customer_code }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->phone }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->address }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center items-center gap-2">

                                    @include('dashboard.customers._actions')

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

    let table = new DataTable('#customersTable');

    $('#customSearch').on('keyup', function () {

        table.search(this.value).draw();

    });

</script>

@endpush