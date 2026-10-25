((jquery) => {
    'use strict';

    if (!jquery) return;

    jquery(() => {
        const $form = jquery('[data-contact-form]');
        if (!$form.length) return;

        $form.attr('novalidate', 'novalidate');

        const $button = $form.find('[data-contact-submit-button]');
        const $label = $form.find('[data-contact-submit-label]');
        const $spinner = $form.find('[data-contact-submit-spinner]');
        const $progress = $form.find('[data-contact-form-progress]');
        const $toast = jquery('[data-contact-form-toast]');
        const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'message'];
        let isSubmitting = false;
        let toastTimer;

        function showToast(message, isError = false) {
            clearTimeout(toastTimer);
            $toast.text(message).toggleClass('is-error', isError).prop('hidden', false);

            if (isError) {
                toastTimer = setTimeout(() => $toast.prop('hidden', true), 5000);
            }
        }

        function showFieldError(field, message) {
            const $field = jquery(field);
            const errorId = `contact-${field.name}-error`;
            const $error = $field.parent().find(`[data-contact-error-for="${field.name}"]`);

            $field.toggleClass('contact-field-invalid', Boolean(message));
            if (message) {
                const $message = $error.length ? $error : jquery('<span>', {
                    class: 'contact-form-error',
                    id: errorId,
                    'data-contact-error-for': field.name,
                    role: 'alert',
                }).appendTo($field.parent());
                $message.text(message);
                $field.attr({ 'aria-invalid': 'true', 'aria-describedby': errorId });
            } else {
                $error.remove();
                $field.removeAttr('aria-invalid aria-describedby');
            }
        }

        function validateField(field) {
            const value = String(jquery(field).val() ?? '').trim();
            const maximum = Number(field.getAttribute('maxlength'));
            let message = '';

            if (requiredFields.includes(field.name) && !value) {
                message = 'This field is required.';
            } else if (value && maximum && value.length > maximum) {
                message = `Use no more than ${maximum} characters.`;
            } else if (field.name === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                message = 'Enter a valid email address.';
            } else if (field.name === 'phone' && value && !/^[0-9]{10}$/.test(value)) {
                message = 'Enter a 10-digit mobile number using numbers only.';
            }

            showFieldError(field, message);
            return !message;
        }

        function setSubmitting(submitting) {
            isSubmitting = submitting;
            $button.prop('disabled', submitting).attr('aria-busy', String(submitting));
            $label.text(submitting ? 'Submitting...' : 'Submit');
            $spinner.prop('hidden', !submitting);
            $progress.text(submitting ? 'Sending your message...' : '').prop('hidden', !submitting);
        }

        $form.on('input change', 'input[name], textarea[name]', function () {
            if ($form.data('contactValidationStarted') || jquery(this).attr('aria-invalid')) {
                validateField(this);
            }
        });

        $form.on('submit', function (event) {
            event.preventDefault();
            if (isSubmitting) return;

            $form.data('contactValidationStarted', true);
            const fields = $form.find('input[name]:not([type="hidden"]), textarea[name]').toArray();
            let firstInvalid = null;
            fields.forEach(field => {
                if (!validateField(field) && !firstInvalid) firstInvalid = field;
            });
            if (firstInvalid) {
                firstInvalid.focus();
                return;
            }

            setSubmitting(true);
            jquery.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                headers: { Accept: 'application/json' },
            }).done((response) => {
                $progress.text('Submitted successfully.').prop('hidden', false);
                showToast(response.message || 'Your message has been received.');
                setTimeout(() => window.location.reload(), 2200);
            }).fail((xhr) => {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    Object.entries(errors).forEach(([name, messages]) => {
                        const field = $form.find(`[name="${name}"]`).get(0);
                        if (field) showFieldError(field, messages[0]);
                    });
                    $form.find('[aria-invalid="true"]').first().trigger('focus');
                    showToast('Please check the highlighted fields.', true);
                } else {
                    showToast('Your message could not be submitted. Please try again.', true);
                }
                setSubmitting(false);
            });
        });
    });
})(window.jQuery);
