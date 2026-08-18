$(document).ready(function () {

    window.customersTable = new DataTable('#customersTable');

    $('#customSearch').on('keyup', function () {
        window.customersTable.search(this.value).draw();
    });

    const editModal = $('#editCustomerModal');

    // ===== EDIT =====

    $(document).on('click', '.js-edit-customer', function () {
        const customerId = $(this).data('id');

        clearEditErrors();

        $.ajax({
            url: '/customers/' + customerId + '/edit',
            type: 'GET',
            success: function (response) {
                const customer = response.customer;

                $('#edit_customer_id').val(customer.id);
                $('#edit_name').val(customer.name);
                $('#edit_phone').val(customer.phone);
                $('#edit_alternate_phone').val(customer.alternate_phone);
                $('#edit_address').val(customer.address);
                $('#edit_notes').val(customer.notes);

                editModal.removeClass('hidden');
            },
            error: function (xhr) {
                showErrorAlert('Load Failed', extractErrorMessage(xhr, 'Unable to load customer details. Please try again.'));
            }
        });
    });

    $('#closeEditModal, #cancelEditBtn').on('click', function () {
        editModal.addClass('hidden');
    });

    $('#editCustomerForm').on('submit', function (e) {
        e.preventDefault();

        const customerId = $('#edit_customer_id').val();
        const $btn = $('#editSubmitBtn');

        clearEditErrors();
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '/customers/' + customerId,
            type: 'PUT',
            data: $('#editCustomerForm').serialize(),
            success: function (response) {
                editModal.addClass('hidden');
                updateCustomerRow(response.customer);
                resetEditButton($btn);
                showSuccessToast('Customer updated.');
            },
            error: function (xhr) {
                resetEditButton($btn);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        $('#editCustomerForm .field-error[data-field="' + field + '"]').text(messages[0]);
                    });

                    showEditAlert('Please fix the errors below.');
                } else {
                    showEditAlert('Something went wrong. Please try again.');
                }
            }
        });
    });

    function updateCustomerRow(customer) {
        const row = $('tr[data-customer-row="' + customer.id + '"]');

        row.find('td').eq(1).text(customer.name);
        row.find('td').eq(2).text(customer.phone);
        row.find('td').eq(3).text(customer.address ?? '');

        window.customersTable.row(row.get(0)).invalidate().draw(false);
    }

    function clearEditErrors() {
        $('#editCustomerForm .field-error').text('');
        $('#editAlertBox').addClass('hidden').removeClass('bg-red-50 text-red-700 border border-red-200').text('');
    }

    function showEditAlert(message) {
        $('#editAlertBox')
            .removeClass('hidden')
            .addClass('bg-red-50 text-red-700 border border-red-200')
            .text(message);
    }

    function resetEditButton($btn) {
        $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Changes');
    }

    // ===== DELETE =====

    $(document).on('click', '.js-delete-customer', function () {
        const customerId = $(this).data('id');
        const customerName = $(this).data('name');

        confirmDelete({
            url: '/customers/' + customerId,
            itemLabel: customerName,
            onSuccess: function () {
                const row = $('tr[data-customer-row="' + customerId + '"]');

                window.customersTable.row(row.get(0)).remove().draw();

                showSuccessToast('Customer deleted.');
            },
            onError: function (xhr) {
                const message = extractErrorMessage(xhr, 'Unable to delete customer. Please try again.', 'customer');

                showErrorAlert('Cannot Delete Customer', message);
            }
        });
    });

});
