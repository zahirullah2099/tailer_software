<div class="flex justify-end gap-2">

    <a href="{{ route('customers.show', $payment->order->customer_id) }}"
       title="View Order"
       class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
        <i class="fa-solid fa-eye text-xs"></i>
    </a>

    <button type="button"
            class="js-delete-payment w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100"
            data-id="{{ $payment->id }}"
            data-name="this payment of Rs. {{ number_format($payment->amount, 2) }}"
            title="Delete">
        <i class="fa-solid fa-trash text-xs"></i>
    </button>

</div>
