$(document).ready(function () {

    const table = new DataTable('#paymentsTable');

    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    $(document).on('click', '.js-delete-payment', function () {
        const paymentId = $(this).data('id');
        const paymentName = $(this).data('name');

        confirmDelete({
            url: '/payments/' + paymentId,
            itemLabel: paymentName,
            onSuccess: function () {
                table.row($('tr[data-payment-row="' + paymentId + '"]').get(0)).remove().draw();

                showSuccessToast('Payment deleted.');
            },
            onError: function (xhr) {
                showErrorAlert('Delete Failed', extractErrorMessage(xhr, 'Unable to delete payment. Please try again.'));
            }
        });
    });

});
