$(document).ready(function () {

    // ===== UPDATE PROFILE =====

    $('#profileForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#profileSubmitBtn');

        clearErrors($form);
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: $form.data('url'),
            type: 'PUT',
            data: $form.serialize(),
            success: function (response) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Changes');
                showAlert('#profileAlertBox', response.message, 'success');
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Changes');
                handleErrors($form, '#profileAlertBox', xhr);
            }
        });
    });

    // ===== CHANGE PASSWORD =====

    $('#passwordForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#passwordSubmitBtn');

        clearErrors($form);
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: $form.data('url'),
            type: 'PUT',
            data: $form.serialize(),
            success: function (response) {
                $form[0].reset();
                $btn.prop('disabled', false).html('<i class="fa-solid fa-lock"></i> Change Password');
                showAlert('#passwordAlertBox', response.message, 'success');
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-lock"></i> Change Password');
                handleErrors($form, '#passwordAlertBox', xhr);
            }
        });
    });

    // ===== HELPERS =====

    function clearErrors($form) {
        $form.find('.field-error').text('');
    }

    function showAlert(selector, message, type) {
        const isSuccess = type === 'success';
        $(selector)
            .removeClass('hidden bg-red-50 text-red-700 border-red-200 bg-green-50 text-green-700 border-green-200')
            .addClass(isSuccess
                ? 'bg-green-50 text-green-700 border border-green-200'
                : 'bg-red-50 text-red-700 border border-red-200')
            .text(message);
    }

    function handleErrors($form, alertSelector, xhr) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            $.each(errors, function (field, messages) {
                $form.find('.field-error[data-field="' + field + '"]').text(messages[0]);
            });
            showAlert(alertSelector, 'Please fix the errors below.', 'error');
        } else {
            showAlert(alertSelector, 'Something went wrong. Please try again.', 'error');
        }
    }

});
