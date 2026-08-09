$(document).ready(function () {

    const modal = $('#measurementModal');
    const form = $('#measurementForm');
    const editUrl = form.data('edit-url');
    const storeUrl = form.data('store-url');

    const numericFields = [
        'chest', 'shoulder', 'sleeve', 'neck', 'shirt_length',
        'waist', 'hip', 'shalwar_length', 'bottom_width',
    ];
    const selectFields = ['collar', 'cuff', 'pocket_type'];

    $('#measurementBtn').on('click', function () {
        clearMeasurementErrors();

        $.ajax({
            url: editUrl,
            type: 'GET',
            success: function (response) {
                const measurement = response.measurement;

                form[0].reset();

                if (measurement) {
                    numericFields.concat(selectFields).forEach(function (field) {
                        $('#m_' + field).val(measurement[field] ?? '');
                    });
                    $('#m_fitting_notes').val(measurement.fitting_notes ?? '');
                }

                modal.removeClass('hidden');
            },
            error: function () {
                alert('Unable to load measurement details. Please try again.');
            }
        });
    });

    $('#closeMeasurementModal, #cancelMeasurementBtn').on('click', function () {
        modal.addClass('hidden');
    });

    form.on('submit', function (e) {
        e.preventDefault();

        const $btn = $('#measurementSubmitBtn');

        clearMeasurementErrors();
        $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: storeUrl,
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                modal.addClass('hidden');
                $('#measurementCard').html(response.card);
                $('#measurementBtnLabel').text('Edit Measurement');
                resetMeasurementButton($btn);
            },
            error: function (xhr) {
                resetMeasurementButton($btn);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        $('#measurementForm .field-error[data-field="' + field + '"]').text(messages[0]);
                    });

                    showMeasurementAlert('Please fix the errors below.');
                } else {
                    showMeasurementAlert('Something went wrong. Please try again.');
                }
            }
        });
    });

    function clearMeasurementErrors() {
        $('#measurementForm .field-error').text('');
        $('#measurementAlertBox').addClass('hidden').removeClass('bg-red-50 text-red-700 border border-red-200').text('');
    }

    function showMeasurementAlert(message) {
        $('#measurementAlertBox')
            .removeClass('hidden')
            .addClass('bg-red-50 text-red-700 border border-red-200')
            .text(message);
    }

    function resetMeasurementButton($btn) {
        $btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk"></i> Save Measurement');
    }

});
