$(document).ready(function () {

    const searchStep = $('#customerSearchStep');
    const selectedCard = $('#selectedCustomerCard');
    const resultsBox = $('#orderCustomerResults');
    const orderDetailsCard = $('#orderDetailsCard');
    const warningBox = $('#noMeasurementWarning');

    let searchTimer;

    // ===== CUSTOMER SEARCH =====

    $('#orderCustomerSearch').on('keyup', function () {
        clearTimeout(searchTimer);
        const term = $(this).val().trim();

        if (term.length < 2) {
            resultsBox.empty();
            return;
        }

        searchTimer = setTimeout(function () {
            $.ajax({
                url: '/orders/customers-search',
                type: 'GET',
                data: { q: term },
                success: function (response) {
                    renderResults(response.customers);
                }
            });
        }, 350);
    });

    function renderResults(customers) {
        resultsBox.empty();

        if (customers.length === 0) {
            resultsBox.html('<p class="text-sm text-gray-400 px-1">No customers found.</p>');
            return;
        }

        customers.forEach(function (customer) {
            const badge = customer.has_measurement
                ? ''
                : '<span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full ml-2">No measurement</span>';

            const item = $(
                '<div class="js-select-customer border border-gray-100 rounded-lg p-3 flex items-center justify-between hover:bg-gray-50 cursor-pointer">' +
                    '<div>' +
                        '<p class="font-medium text-gray-800">' + escapeHtml(customer.name) + badge + '</p>' +
                        '<p class="text-sm text-gray-500">' + escapeHtml(customer.customer_code) + ' &middot; ' + escapeHtml(customer.phone) + '</p>' +
                    '</div>' +
                    '<i class="fa-solid fa-chevron-right text-gray-300"></i>' +
                '</div>'
            );

            item.on('click', function () {
                selectCustomer(customer);
            });

            resultsBox.append(item);
        });
    }

    function selectCustomer(customer) {
        $('#order_customer_id').val(customer.id);
        $('#order_measurement_id').val(customer.measurement_id ?? '');

        $('#selectedCustomerName').text(customer.name);
        $('#selectedCustomerMeta').text(customer.customer_code + ' \u00b7 ' + customer.phone);
        $('#addMeasurementLink').attr('href', '/customers/' + customer.id);

        searchStep.addClass('hidden');
        selectedCard.removeClass('hidden');
        resultsBox.empty();
        $('#orderCustomerSearch').val('');

        if (customer.has_measurement) {
            warningBox.addClass('hidden');
            orderDetailsCard.removeClass('hidden');
        } else {
            warningBox.removeClass('hidden');
            orderDetailsCard.addClass('hidden');
        }
    }

    $('#changeCustomerBtn').on('click', function () {
        selectedCard.addClass('hidden');
        orderDetailsCard.addClass('hidden');
        searchStep.removeClass('hidden');
        $('#order_customer_id').val('');
        $('#order_measurement_id').val('');
    });

    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }

    // ===== ORDER SUBMISSION =====

    $('#orderForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#orderSubmitBtn');

        $('.field-error').text('');
        $('#orderAlertBox').addClass('hidden').text('');

        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Creating...');

        $.ajax({
            url: $form.data('store-url'),
            type: 'POST',
            data: $form.serialize(),
            success: function (response) {
                window.location.href = response.redirect_url;
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Create Order');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        $('.field-error[data-field="' + field + '"]').text(messages[0]);
                    });

                    $('#orderAlertBox')
                        .removeClass('hidden')
                        .addClass('bg-red-50 text-red-700 border border-red-200')
                        .text('Please fix the errors below.');
                } else {
                    $('#orderAlertBox')
                        .removeClass('hidden')
                        .addClass('bg-red-50 text-red-700 border border-red-200')
                        .text('Something went wrong. Please try again.');
                }
            }
        });
    });

});
