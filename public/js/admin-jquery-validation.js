(function ($) {
    'use strict';

    $(function () {
        $('[data-jquery-validation]').each(function () {
            const $form = $(this);

            function validateField(field) {
                const $field = $(field);
                const isFile = field.type === 'file';
                const removeImageChecked = $form.find('[name="remove_image"]').is(':checked');
                const requiredByRemoval = $field.is('[data-jquery-required-if-remove]') && removeImageChecked;
                const isRequired = $field.is('[data-jquery-required]') || requiredByRemoval;
                const hasExistingImage = isFile && $field.is('[data-has-existing-image]') && !removeImageChecked;
                const value = $field.val();
                const isEmpty = isFile ? !field.files.length : !String(value ?? '').trim();
                let message = '';

                if (isRequired && isEmpty && !hasExistingImage) {
                    message = 'This field is required.';
                } else if (!isEmpty && field.type === 'url' && field.validity.typeMismatch) {
                    message = 'Enter a valid URL.';
                }

                const errorId = `jquery-validation-${field.name.replace(/[^a-zA-Z0-9_-]/g, '-')}`;
                let $error = $form.find('[data-validation-for]').filter(function () {
                    return this.dataset.validationFor === field.name;
                });
                if (!$error.length) {
                    $error = $field.closest('label').next('.jquery-validation-error');
                }

                if (message) {
                    if (!$error.length) {
                        $error = $('<span>', {
                            class: 'jquery-validation-error',
                            role: 'alert',
                            id: errorId,
                            'data-validation-for': field.name,
                        });
                        $field.closest('label').append($error);
                    }
                    $error.text(message);
                    $field.attr({ 'aria-invalid': 'true', 'aria-describedby': errorId });

                    return false;
                }

                $error.remove();
                $field.removeAttr('aria-invalid aria-describedby');

                return true;
            }

            $form.on('submit', function (event) {
                let firstInvalid = null;

                $form.find('[data-jquery-required], [data-jquery-required-if-remove]').each(function () {
                    if (!validateField(this) && firstInvalid === null) {
                        firstInvalid = this;
                    }
                });

                if (firstInvalid) {
                    event.preventDefault();
                    firstInvalid.focus();
                }
            });

            $form.on('input change', '[data-jquery-required], [data-jquery-required-if-remove]', function () {
                validateField(this);
            });
        });
    });
})(jQuery);
