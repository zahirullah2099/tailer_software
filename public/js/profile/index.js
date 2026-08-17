$(document).ready(function () {

    // ===== AVATAR UPLOAD =====

    $('#avatarInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $('#avatarMsg').removeClass('hidden text-red-500 text-green-600').addClass('text-gray-400').text('Uploading...');

        $.ajax({
            url: $('#avatarInput').data('url'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#avatarPreview').attr('src', response.avatar_url).removeClass('hidden');
                $('#avatarIconFallback').addClass('hidden');
                // Update navbar avatar too
                $('#navAvatar').attr('src', response.avatar_url);
                $('#navAvatarIcon').addClass('hidden');
                $('#avatarMsg').removeClass('text-gray-400').addClass('text-green-600').text('Photo updated successfully.');
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.errors?.avatar?.[0] ?? 'Upload failed. Please try again.';
                $('#avatarMsg').removeClass('hidden text-gray-400').addClass('text-red-500').text(msg);
            }
        });
    });

    // ===== UPDATE PROFILE =====

    $('#profileForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#profileSubmitBtn');

        clearErrors($form);
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Saving...');

        $.ajax({
            url: $form.data('url'),
            type: 'PUT',
            data: $form.serialize(),
            success: function (response) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Changes');
                showAlert('#profileAlertBox', response.message, 'success');
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Changes');
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
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Updating...');

        $.ajax({
            url: $form.data('url'),
            type: 'PUT',
            data: $form.serialize(),
            success: function (response) {
                $form[0].reset();
                $btn.prop('disabled', false).html('<i class="fa-solid fa-lock mr-1.5"></i> Change Password');
                showAlert('#passwordAlertBox', response.message, 'success');
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-lock mr-1.5"></i> Change Password');
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
            $.each(xhr.responseJSON.errors, function (field, messages) {
                $form.find('.field-error[data-field="' + field + '"]').text(messages[0]);
            });
            showAlert(alertSelector, 'Please fix the errors below.', 'error');
        } else {
            showAlert(alertSelector, 'Something went wrong. Please try again.', 'error');
        }
    }

});
