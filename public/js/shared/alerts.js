/**
 * Shared SweetAlert2 helpers.
 * Keeps delete-confirmation and error-alert UI consistent across every module.
 */

/**
 * Show a confirm-before-delete dialog, then perform the DELETE request.
 *
 * @param {Object} options
 * @param {string} options.url - Endpoint to send the DELETE request to.
 * @param {string} [options.itemLabel] - Human-readable name of what's being deleted, e.g. "Ali Khan" or "Order #123".
 * @param {string} [options.title] - Dialog title. Defaults to "Delete {itemLabel}?".
 * @param {string} [options.text] - Dialog body text.
 * @param {function} options.onSuccess - Called with the AJAX response on success.
 * @param {function} [options.onError] - Called with the jqXHR on failure. Falls back to a generic error alert.
 */
function confirmDelete({ url, itemLabel = 'this item', title = null, text = null, onSuccess, onError = null }) {
    Swal.fire({
        icon: 'warning',
        title: title ?? `Delete ${itemLabel}?`,
        text: text ?? 'This action cannot be undone.',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
    }).then((result) => {
        if (!result.isConfirmed) {
            return;
        }

        $.ajax({
            url: url,
            type: 'DELETE',
            success: function (response) {
                if (onSuccess) {
                    onSuccess(response);
                }
            },
            error: function (xhr) {
                if (onError) {
                    onError(xhr);
                    return;
                }

                showErrorAlert('Delete Failed', extractErrorMessage(xhr, 'Unable to delete. Please try again.'));
            },
        });
    });
}

/**
 * Show a simple error/warning alert.
 */
function showErrorAlert(title, message) {
    Swal.fire({
        icon: 'warning',
        title: title,
        text: message,
        confirmButtonColor: '#2563eb',
    });
}

/**
 * Show a brief success toast (top-right, auto-dismisses).
 */
function showSuccessToast(message) {
    Swal.fire({
        icon: 'success',
        title: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });
}

/**
 * Pull a usable message out of a failed jQuery AJAX response.
 * Prefers a 422 validation message under the given field, then any first validation error, then the fallback text.
 */
function extractErrorMessage(xhr, fallback, field = null) {
    if (xhr.status === 422 && xhr.responseJSON?.errors) {
        const errors = xhr.responseJSON.errors;

        if (field && errors[field]) {
            return errors[field][0];
        }

        const firstKey = Object.keys(errors)[0];

        if (firstKey) {
            return errors[firstKey][0];
        }
    }

    return fallback;
}
