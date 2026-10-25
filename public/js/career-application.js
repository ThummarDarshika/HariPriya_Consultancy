((jquery) => {
    'use strict';

    if (!jquery) return;

    jquery(() => {
        const $form = jquery('[data-career-form]');
        if (!$form.length) return;

        const $button = $form.find('[data-career-submit]');
        const $status = $form.find('[data-career-status]');
        const maximumResumeBytes = 5 * 1024 * 1024;
        const buttonLabel = $button.html();
        let isSubmitting = false;

        function showError(field, message) {
            const $field = jquery(field);
            $form.find('[data-career-error]').filter((_, element) => element.dataset.careerError === field.name).text(message);
            $field.attr('aria-invalid', String(Boolean(message)));
        }

        function validate(field) {
            const value = String(jquery(field).val() ?? '').trim();
            const file = field.files?.[0];
            let error = '';

            if (field.type === 'checkbox' && !field.checked) error = 'Please agree before submitting.';
            else if (field.type === 'file' && !file) error = 'Please choose a PDF, DOC or DOCX resume.';
            else if (field.hasAttribute('data-career-required') && field.type !== 'file' && !value) error = 'This field is required.';
            else if (field.type === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) error = 'Enter a valid email address.';
            else if (field.name === 'phone' && value && !/^[0-9]{10}$/.test(value)) error = 'Enter a 10-digit mobile number using numbers only.';
            else if (field.name === 'experience_years' && value && (!Number.isInteger(Number(value)) || Number(value) < 0 || Number(value) > 60)) error = 'Enter 0 to 60 years.';
            else if (field.name === 'cover_letter' && value && value.length < 20) error = 'Please enter at least 20 characters.';
            else if (file && file.size > maximumResumeBytes) error = `Your resume is ${(file.size / 1048576).toFixed(2)} MB; the maximum allowed size is 5 MB.`;
            else if (file && !/\.(pdf|doc|docx)$/i.test(file.name)) {
                const extension = file.name.includes('.') ? `.${file.name.split('.').pop().toLowerCase()}` : 'missing';
                error = `The selected file has a ${extension} extension. Upload PDF, DOC or DOCX.`;
            }

            showError(field, error);
            return !error;
        }

        function setSubmitting(submitting) {
            isSubmitting = submitting;
            $button.prop('disabled', submitting).attr('aria-busy', String(submitting));
            $button.html(submitting ? 'Submitting application...' : buttonLabel);
        }

        function showStatus(message, isError = false) {
            $status.text(message).toggleClass('is-error', isError).prop('hidden', false);
        }

        $form.on('input change', '[data-career-required]', function () { validate(this); });
        $form.on('submit', function (event) {
            event.preventDefault();
            if (isSubmitting) return;

            let firstInvalid;
            $form.find('[data-career-required]').each(function () {
                if (!validate(this) && !firstInvalid) firstInvalid = this;
            });
            if (firstInvalid) {
                showStatus('Please correct the highlighted fields and try again.', true);
                firstInvalid.focus();
                return;
            }

            $status.prop('hidden', true);
            setSubmitting(true);
            jquery.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: new FormData($form.get(0)),
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: { Accept: 'application/json' },
            }).done((response) => {
                $form.get(0).reset();
                $form.find('[data-career-error]').text('');
                $form.find('[aria-invalid]').removeAttr('aria-invalid');
                showStatus(response.message || 'Your application has been submitted successfully.');
            }).fail((xhr) => {
                const errors = xhr.responseJSON?.errors;
                if (errors && (xhr.status === 422 || xhr.status === 413)) {
                    Object.entries(errors).forEach(([name, messages]) => {
                        const field = $form.find('[name]').filter((_, element) => element.name === name).get(0);
                        if (field) showError(field, messages[0]);
                    });
                    showStatus('Please correct the highlighted fields and try again.', true);
                    $form.find('[aria-invalid="true"]').first().trigger('focus');
                } else {
                    showStatus(xhr.responseJSON?.message || 'Your application could not be submitted. Please try again.', true);
                }
            }).always(() => setSubmitting(false));
        });
    });
})(window.jQuery);
