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
            error: function () {
                alert('Unable to update status. Please try again.');
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
            error: function () {
                alert('Unable to load order details. Please try again.');
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

    const deleteModal = $('#deleteOrderModal');
    let orderIdToDelete = null;

    $(document).on('click', '.js-delete-order', function () {
        orderIdToDelete = $(this).data('id');
        $('#deleteOrderName').text($(this).data('name'));
        deleteModal.removeClass('hidden');
    });

    $('#cancelDeleteOrderBtn').on('click', function () {
        orderIdToDelete = null;
        deleteModal.addClass('hidden');
    });

    $('#confirmDeleteOrderBtn').on('click', function () {
        if (!orderIdToDelete) {
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Deleting...');

        $.ajax({
            url: '/orders/' + orderIdToDelete,
            type: 'DELETE',
            success: function () {
                table.row($('tr[data-order-row="' + orderIdToDelete + '"]').get(0)).remove().draw();

                deleteModal.addClass('hidden');
                orderIdToDelete = null;
                resetDeleteOrderButton($btn);
            },
            error: function () {
                alert('Unable to delete order. Please try again.');
                resetDeleteOrderButton($btn);
            }
        });
    });

    function resetDeleteOrderButton($btn) {
        $btn.prop('disabled', false).html('<i class="fa-solid fa-trash"></i> Yes, Delete');
    }

});
