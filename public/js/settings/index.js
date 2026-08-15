$(document).ready(function () {

    // ===== LOGO UPLOAD =====

    $('#logoInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('shop_logo', file);
        formData.append('shop_name', $('input[name="shop_name"]').val());
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $('#logoMsg').removeClass('hidden text-red-500 text-green-600').addClass('text-gray-400').text('Uploading...');

        $.ajax({
            url: $('#settingsForm').data('url'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.shop_logo_url) {
                    $('#logoPreview').attr('src', response.shop_logo_url).removeClass('hidden');
                    $('#logoIconFallback').addClass('hidden');
                    // Update navbar logo too
                    if ($('#navLogoImg').length) {
                        $('#navLogoImg').attr('src', response.shop_logo_url);
                    } else {
                        $('#navLogoWrapper').html('<img id="navLogoImg" src="' + response.shop_logo_url + '" class="w-full h-full object-cover">');
                    }
                }
                $('#logoMsg').removeClass('text-gray-400').addClass('text-green-600').text('Logo updated successfully.');
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.errors?.shop_logo?.[0] ?? 'Upload failed.';
                $('#logoMsg').removeClass('hidden text-gray-400').addClass('text-red-500').text(msg);
            }
        });
    });

    // ===== SAVE SETTINGS =====

    $('#settingsForm').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#settingsSubmitBtn');

        $form.find('.field-error').text('');
        $('#settingsAlertBox').addClass('hidden').text('');

        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin mr-1.5"></i> Saving...');

        $.ajax({
            url: $form.data('url'),
            type: 'POST',
            data: $form.serialize(),
            success: function (response) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Settings');

                // Update navbar shop name live
                $('#navShopName').text(response.shop_name);

                $('#settingsAlertBox')
                    .removeClass('hidden bg-red-50 text-red-700 border-red-200')
                    .addClass('bg-green-50 text-green-700 border border-green-200')
                    .text(response.message);
            },
            error: function (xhr) {
                $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk mr-1.5"></i> Save Settings');

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function (field, messages) {
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
