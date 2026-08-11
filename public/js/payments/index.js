$(document).ready(function () {

    const table = new DataTable('#paymentsTable');

    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    const deleteModal = $('#deletePaymentModal');
    let paymentIdToDelete = null;

    $(document).on('click', '.js-delete-payment', function () {
        paymentIdToDelete = $(this).data('id');
        $('#deletePaymentName').text($(this).data('name'));
        deleteModal.removeClass('hidden');
    });

    $('#cancelDeletePaymentBtn').on('click', function () {
        paymentIdToDelete = null;
        deleteModal.addClass('hidden');
    });

    $('#confirmDeletePaymentBtn').on('click', function () {
        if (!paymentIdToDelete) {
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Deleting...');

        $.ajax({
            url: '/payments/' + paymentIdToDelete,
            type: 'DELETE',
            success: function () {
                table.row($('tr[data-payment-row="' + paymentIdToDelete + '"]').get(0)).remove().draw();

                deleteModal.addClass('hidden');
                paymentIdToDelete = null;
                resetDeleteButton($btn);
            },
            error: function () {
                alert('Unable to delete payment. Please try again.');
                resetDeleteButton($btn);
            }
        });
    });

    function resetDeleteButton($btn) {
        $btn.prop('disabled', false).html('<i class="fa-solid fa-trash"></i> Yes, Delete');
    }

});
