$(document).ready(function () {

    $('#customerForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const storeUrl = $form.data('store-url');

        $('.field-error').text('');
        $('#alertBox').addClass('hidden').text('');

        const $btn = $('#submitBtn');
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: storeUrl,
            type: 'POST',
            data: $form.serialize(),
            success: function (response) {
                window.location.href = response.redirect_url;
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Customer');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        $('.field-error[data-field="' + field + '"]').text(messages[0]);
                    });

                    $('#alertBox')
                        .removeClass('hidden')
                        .addClass('bg-red-50 text-red-700 border border-red-200')
                        .text('Please fix the errors below.');
                } else {
                    $('#alertBox')
                        .removeClass('hidden')
                        .addClass('bg-red-50 text-red-700 border border-red-200')
                        .text('Something went wrong. Please try again.');
                }
            }
        });
    });

});
