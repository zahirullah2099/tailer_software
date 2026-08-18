$(document).ready(function () {

    const table = new DataTable('#ordersTable');

    // ===== SEARCH =====

    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    // ===== STATUS FILTER =====

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'ordersTable') {
            return true;
        }

        const statusFilter = $('#statusFilter').val();

        if (!statusFilter) {
            return true;
        }

        const row = settings.aoData[dataIndex].nTr;

        return $(row).data('status') === statusFilter;
    });

    $('#statusFilter').on('change', function () {
        table.draw();
    });

    // ===== INLINE STATUS UPDATE =====

    $(document).on('change', '.js-status-select', function () {
        const $select = $(this);
        const orderId = $select.data('order-id');
        const newStatus = $select.val();
        const row = $select.closest('tr');

        $select.prop('disabled', true);

        $.ajax({
            url: '/orders/' + orderId + '/status',
            type: 'PUT',
            data: { status: newStatus },
            success: function () {
                row.attr('data-status', newStatus);
                $select.prop('disabled', false);
            },
            error: function (xhr) {
                showErrorAlert('Update Failed', extractErrorMessage(xhr, 'Unable to update status. Please try again.'));
                $select.prop('disabled', false);
            }
        });
    });

    // ===== EDIT =====

    const editModal = $('#editOrderModal');

    $(document).on('click', '.js-edit-order', function () {
        const orderId = $(this).data('id');

        clearEditOrderErrors();

        $.ajax({
            url: '/orders/' + orderId + '/edit',
            type: 'GET',
            success: function (response) {
                const order = response.order;

                $('#edit_order_id').val(order.id);
                $('#edit_order_dress_type').val(order.dress_type);
                $('#edit_order_quantity').val(order.quantity);
                $('#edit_order_total_amount').val(order.total_amount);
                $('#edit_order_date').val(order.order_date);
                $('#edit_order_delivery_date').val(order.delivery_date);
                $('#edit_order_notes').val(order.notes);

                editModal.removeClass('hidden');
            },
            error: function (xhr) {
                showErrorAlert('Load Failed', extractErrorMessage(xhr, 'Unable to load order details. Please try again.'));
            }
        });
    });

    $('#closeEditOrderModal, #cancelEditOrderBtn').on('click', function () {
        editModal.addClass('hidden');
    });

    $('#editOrderForm').on('submit', function (e) {
        e.preventDefault();

        const orderId = $('#edit_order_id').val();
        const $btn = $('#editOrderSubmitBtn');

        clearEditOrderErrors();
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '/orders/' + orderId,
            type: 'PUT',
            data: $('#editOrderForm').serialize(),
            success: function () {
                editModal.addClass('hidden');
                resetEditOrderButton($btn);
                window.location.reload();
            },
            error: function (xhr) {
                resetEditOrderButton($btn);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        $('#editOrderForm .field-error[data-field="' + field + '"]').text(messages[0]);
                    });

                    showEditOrderAlert('Please fix the errors below.');
                } else {
                    showEditOrderAlert('Something went wrong. Please try again.');
                }
            }
        });
    });

    function clearEditOrderErrors() {
        $('#editOrderForm .field-error').text('');
        $('#editOrderAlertBox').addClass('hidden').removeClass('bg-red-50 text-red-700 border border-red-200').text('');
    }

    function showEditOrderAlert(message) {
        $('#editOrderAlertBox')
            .removeClass('hidden')
            .addClass('bg-red-50 text-red-700 border border-red-200')
            .text(message);
    }

    function resetEditOrderButton($btn) {
        $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Changes');
    }

    // ===== DELETE =====

    $(document).on('click', '.js-delete-order', function () {
        const orderId = $(this).data('id');
        const orderName = $(this).data('name');

        confirmDelete({
            url: '/orders/' + orderId,
            itemLabel: orderName,
            onSuccess: function () {
                table.row($('tr[data-order-row="' + orderId + '"]').get(0)).remove().draw();

                showSuccessToast('Order deleted.');
            },
            onError: function (xhr) {
                showErrorAlert('Delete Failed', extractErrorMessage(xhr, 'Unable to delete order. Please try again.'));
            }
        });
    });

    // ===== ADD PAYMENT =====

    const paymentModal = $('#addPaymentModal');

    $(document).on('click', '.js-add-payment', function () {
        const orderId = $(this).data('id');

        clearPaymentErrors();
        $('#paymentForm')[0].reset();
        $('#payment_paid_at').val(new Date().toISOString().slice(0, 10));

        $.ajax({
            url: '/orders/' + orderId + '/payment-info',
            type: 'GET',
            success: function (response) {
                const order = response.order;

                $('#payment_order_id').val(order.id);
                $('#payment_order_number').text(order.order_number);
                $('#payment_customer_name').text(order.customer_name);
                $('#payment_total_amount').text('Rs. ' + order.total_amount.toFixed(2));
                $('#payment_already_paid').text('Rs. ' + order.paid.toFixed(2));
                $('#payment_balance_due').text('Rs. ' + order.balance.toFixed(2));
                $('#payment_amount').attr('max', order.balance);

                paymentModal.removeClass('hidden');
            },
            error: function (xhr) {
                showErrorAlert('Load Failed', extractErrorMessage(xhr, 'Unable to load order payment info. Please try again.'));
            }
        });
    });

    $('#closePaymentModal, #cancelPaymentBtn').on('click', function () {
        paymentModal.addClass('hidden');
    });

    $('#paymentForm').on('submit', function (e) {
        e.preventDefault();

        const $btn = $('#paymentSubmitBtn');

        clearPaymentErrors();
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '/payments',
            type: 'POST',
            data: $('#paymentForm').serialize(),
            success: function (response) {
                paymentModal.addClass('hidden');
                resetPaymentButton($btn);

                const row = $('tr[data-order-row="' + response.order_id + '"]');
                row.find('[data-order-paid="' + response.order_id + '"]').text('Rs. ' + response.paid.toFixed(2));

                const balanceCell = row.find('[data-order-balance="' + response.order_id + '"]');
                balanceCell.text('Rs. ' + response.balance.toFixed(2));
                balanceCell.toggleClass('text-red-600 font-medium', response.balance > 0);
                balanceCell.toggleClass('text-gray-400', response.balance <= 0);
            },
            error: function (xhr) {
                resetPaymentButton($btn);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        $('#paymentForm .field-error[data-field="' + field + '"]').text(messages[0]);
                    });

                    showPaymentAlert('Please fix the errors below.');
                } else {
                    showPaymentAlert('Something went wrong. Please try again.');
                }
            }
        });
    });

    function clearPaymentErrors() {
        $('#paymentForm .field-error').text('');
        $('#paymentAlertBox').addClass('hidden').removeClass('bg-red-50 text-red-700 border border-red-200').text('');
    }

    function showPaymentAlert(message) {
        $('#paymentAlertBox')
            .removeClass('hidden')
            .addClass('bg-red-50 text-red-700 border border-red-200')
            .text(message);
    }

    function resetPaymentButton($btn) {
        $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Payment');
    }

});
