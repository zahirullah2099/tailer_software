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

        <div class="overflow-x-auto">

            <table id="customersTable" class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr class="text-left text-gray-600">

                        <th class="px-6 py-4 font-semibold">Customer Code</th>
                        <th class="px-6 py-4 font-semibold">Name</th>
                        <th class="px-6 py-4 font-semibold">Phone</th>
                        <th class="px-6 py-4 font-semibold">Address</th>
                        <th class="px-6 py-4 font-semibold text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($customers as $customer)

                        <tr data-customer-row="{{ $customer->id }}" class="border-t hover:bg-gray-50">

                            <td class="px-6 py-4 font-medium">{{ $customer->customer_code }}</td>
                            <td class="px-6 py-4">{{ $customer->name }}</td>
                            <td class="px-6 py-4">{{ $customer->phone }}</td>
                            <td class="px-6 py-4">{{ $customer->address }}</td>

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

<!-- Edit Customer Modal -->
<div id="editCustomerModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Edit Customer</h2>
            <button type="button" id="closeEditModal" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div id="editAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <form id="editCustomerForm">
            @csrf
            <input type="hidden" id="edit_customer_id">

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" id="edit_name"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="name"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <input type="text" name="phone" id="edit_phone"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alternate Phone</label>
                    <input type="text" name="alternate_phone" id="edit_alternate_phone"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="alternate_phone"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="edit_address"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="address"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" id="edit_notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="notes"></p>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="cancelEditBtn"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" id="editSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Changes
                </button>
            </div>

        </form>

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteCustomerModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 text-center">

        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mb-1">Delete Customer?</h2>

        <p class="text-sm text-gray-500 mb-6">
            Are you sure you want to delete <span id="deleteCustomerName" class="font-medium text-gray-700"></span>?
        </p>

        <div class="flex justify-center gap-3">
            <button type="button" id="cancelDeleteBtn"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" id="confirmDeleteBtn"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg">
                <i class="fa-solid fa-trash"></i>
                Yes, Delete
            </button>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/customers/index.js') }}"></script>
@endpush
