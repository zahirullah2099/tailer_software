$(document).ready(function () {

    $('#settingsForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#settingsSubmitBtn');

        $form.find('.field-error').text('');
        $('#settingsAlertBox').addClass('hidden').text('');

        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: $form.data('url'),
            type: 'PUT',
            data: $form.serialize(),
            success: function (response) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Settings');
                $('#settingsAlertBox')
                    .removeClass('hidden')
                    .addClass('bg-green-50 text-green-700 border border-green-200')
                    .text(response.message);
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Settings');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        $form.find('.field-error[data-field="' + field + '"]').text(messages[0]);
                    });
                    $('#settingsAlertBox')
                        .removeClass('hidden')
                        .addClass('bg-red-50 text-red-700 border border-red-200')
                        .text('Please fix the errors below.');
                } else {
                    $('#settingsAlertBox')
                        .removeClass('hidden')
                        .addClass('bg-red-50 text-red-700 border border-red-200')
                        .text('Something went wrong. Please try again.');
                }
            }
        });
    });

});
