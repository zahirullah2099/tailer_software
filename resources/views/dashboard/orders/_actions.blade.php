<div class="flex justify-end gap-2">

    <a href="{{ route('customers.show', $order->customer_id) }}"
       title="View"
       class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100">
        <i class="fa-solid fa-eye text-xs"></i>
    </a>

    <button type="button"
            class="js-edit-order w-8 h-8 flex items-center justify-center rounded-lg bg-green-50 text-green-600 hover:bg-green-100"
            data-id="{{ $order->id }}"
            title="Edit">
        <i class="fa-solid fa-pen text-xs"></i>
    </button>

    <button type="button"
            class="js-delete-order w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100"
            data-id="{{ $order->id }}"
            data-name="{{ $order->order_number }}"
            title="Delete">
        <i class="fa-solid fa-trash text-xs"></i>
    </button>

</div>
