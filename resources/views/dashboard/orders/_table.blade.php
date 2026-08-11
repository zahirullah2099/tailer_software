<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $pageTitle }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $pageDescription }}</p>
        </div>

        <a href="{{ route('orders.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow">
            <i class="fa-solid fa-plus"></i>
            <span>New Order</span>
        </a>

    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row md:items-center gap-3">

        <input
            type="text"
            id="customSearch"
            placeholder="Search by order # or customer..."
            class="flex-1 max-w-md border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

        @if ($statuses->count() > 1)
            <div class="flex items-center gap-3">
                <label class="text-sm font-medium text-gray-600">Status:</label>
                <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All</option>
                    @foreach ($statuses as $case)
                        <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                    @endforeach
                </select>
            </div>
        @endif

    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-2">

        <div class="overflow-x-auto">

            <table id="ordersTable" class="min-w-full text-sm">

                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-600">
                        <th class="px-6 py-4 font-semibold">Order #</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Dress Type</th>
                        <th class="px-6 py-4 font-semibold">Qty</th>
                        <th class="px-6 py-4 font-semibold">Amount</th>
                        <th class="px-6 py-4 font-semibold">Paid</th>
                        <th class="px-6 py-4 font-semibold">Due</th>
                        <th class="px-6 py-4 font-semibold">Order Date</th>
                        <th class="px-6 py-4 font-semibold">Delivery Date</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($orders as $order)

                        <tr data-order-row="{{ $order->id }}" data-status="{{ $order->status->value }}" class="border-t hover:bg-gray-50">

                            <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>

                            <td class="px-6 py-4">
                                <div>{{ $order->customer->name }}</div>
                                <div class="text-xs text-gray-400">{{ $order->customer->phone }}</div>
                            </td>

                            <td class="px-6 py-4">{{ ucwords(str_replace('_', ' ', $order->dress_type->value)) }}</td>
                            <td class="px-6 py-4">{{ $order->quantity }}</td>
                            <td class="px-6 py-4">Rs. {{ number_format($order->total_amount, 2) }}</td>

                            @php
                                $paid = $order->payments->sum('amount');
                                $balance = $order->total_amount - $paid;
                            @endphp

                            <td class="px-6 py-4 text-green-700" data-order-paid="{{ $order->id }}">
                                Rs. {{ number_format($paid, 2) }}
                            </td>

                            <td class="px-6 py-4 {{ $balance > 0 ? 'text-red-600 font-medium' : 'text-gray-400' }}" data-order-balance="{{ $order->id }}">
                                Rs. {{ number_format($balance, 2) }}
                            </td>
                            <td class="px-6 py-4">{{ $order->order_date->format('d M, Y') }}</td>
                            <td class="px-6 py-4">{{ $order->delivery_date?->format('d M, Y') ?? '-' }}</td>

                            <td class="px-6 py-4">
                                <select class="js-status-select text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        data-order-id="{{ $order->id }}">
                                    @foreach (\App\Enums\OrderStatus::cases() as $case)
                                        <option value="{{ $case->value }}" @selected($order->status === $case)>
                                            {{ ucfirst($case->value) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    @include('dashboard.orders._actions')
                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-10 text-center text-gray-400">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- Edit Order Modal -->
<div id="editOrderModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Edit Order</h2>
            <button type="button" id="closeEditOrderModal" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div id="editOrderAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <form id="editOrderForm">
            @csrf
            <input type="hidden" id="edit_order_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dress Type *</label>
                    <select name="dress_type" id="edit_order_dress_type"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach (\App\Enums\DressType::cases() as $case)
                            <option value="{{ $case->value }}">{{ ucwords(str_replace('_', ' ', $case->value)) }}</option>
                        @endforeach
                    </select>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="dress_type"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                    <input type="number" name="quantity" min="1" id="edit_order_quantity"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="quantity"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount (Rs.) *</label>
                    <input type="number" step="0.01" name="total_amount" id="edit_order_total_amount"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="total_amount"></p>
                </div>

                <div></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Date *</label>
                    <input type="date" name="order_date" id="edit_order_date"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="order_date"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Date</label>
                    <input type="date" name="delivery_date" id="edit_order_delivery_date"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="delivery_date"></p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" id="edit_order_notes" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="notes"></p>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="cancelEditOrderBtn"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" id="editOrderSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Changes
                </button>
            </div>

        </form>

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteOrderModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 text-center">

        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mb-1">Delete Order?</h2>

        <p class="text-sm text-gray-500 mb-6">
            Are you sure you want to delete <span id="deleteOrderName" class="font-medium text-gray-700"></span>?
        </p>

        <div class="flex justify-center gap-3">
            <button type="button" id="cancelDeleteOrderBtn"
                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button type="button" id="confirmDeleteOrderBtn"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg">
                <i class="fa-solid fa-trash"></i>
                Yes, Delete
            </button>
        </div>

    </div>
</div>

<!-- Add Payment Modal -->
<div id="addPaymentModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Record Payment</h2>
            <button type="button" id="closePaymentModal" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div id="paymentAlertBox" class="hidden mb-4 px-4 py-3 rounded-lg text-sm"></div>

        <div class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-4 text-sm">
            <div class="flex justify-between mb-1">
                <span class="text-gray-500">Order</span>
                <span class="font-medium text-gray-800" id="payment_order_number"></span>
            </div>
            <div class="flex justify-between mb-1">
                <span class="text-gray-500">Customer</span>
                <span class="font-medium text-gray-800" id="payment_customer_name"></span>
            </div>
            <div class="flex justify-between mb-1">
                <span class="text-gray-500">Total Amount</span>
                <span class="text-gray-700" id="payment_total_amount"></span>
            </div>
            <div class="flex justify-between mb-1">
                <span class="text-gray-500">Already Paid</span>
                <span class="text-green-700" id="payment_already_paid"></span>
            </div>
            <div class="flex justify-between font-semibold border-t border-gray-200 mt-2 pt-2">
                <span class="text-gray-600">Balance Due</span>
                <span class="text-red-600" id="payment_balance_due"></span>
            </div>
        </div>

        <form id="paymentForm">
            @csrf
            <input type="hidden" name="order_id" id="payment_order_id">

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount (Rs.) *</label>
                    <input type="number" step="0.01" name="amount" id="payment_amount"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="amount"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                    <select name="payment_method" id="payment_method"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach (\App\Enums\PaymentMethod::cases() as $case)
                            <option value="{{ $case->value }}">{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="payment_method"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date *</label>
                    <input type="date" name="paid_at" id="payment_paid_at" value="{{ now()->format('Y-m-d') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="paid_at"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                    <textarea name="remarks" id="payment_remarks" rows="2"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-red-600 text-sm mt-1 field-error" data-field="remarks"></p>
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="cancelPaymentBtn"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" id="paymentSubmitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Payment
                </button>
            </div>

        </form>

    </div>
</div>
