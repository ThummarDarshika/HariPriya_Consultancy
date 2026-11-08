(() => {
    const form = document.querySelector('[data-brochure-form]');
    if (!form) return;

    const input = form.querySelector('input[name="upload"]');
    const remove = form.querySelector('input[name="remove"]');
    const selection = document.getElementById('brochure-file-selection');
    const dropzone = form.querySelector('.brochure-dropzone');
    const submit = form.querySelector('.brochure-save-button');
    const submitLabel = form.querySelector('[data-brochure-submit-label]');
    const maxBytes = 50 * 1024 * 1024;

    const showSelection = (message, isError = false) => {
        selection.textContent = message;
        selection.hidden = false;
        selection.classList.toggle('is-error', isError);
    };

    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (!file) {
            selection.hidden = true;
            return;
        }

        if (file.size > maxBytes) {
            showSelection('This file is larger than 50 MB. Choose a smaller PDF.', true);
            input.value = '';
            return;
        }

        if (!file.name.toLowerCase().endsWith('.pdf')) {
            showSelection('Choose a PDF file.', true);
            input.value = '';
            return;
        }

        if (remove) {
            remove.checked = false;
            submit.classList.remove('is-remove');
            submitLabel.textContent = 'Save new brochure';
        }
        showSelection(`${file.name} · ${(file.size / 1048576).toFixed(2)} MB selected`);
    });

    remove?.addEventListener('change', () => {
        if (remove.checked) {
            input.value = '';
            selection.hidden = true;
        }
        submit.classList.toggle('is-remove', remove.checked);
        submitLabel.textContent = remove.checked ? 'Remove brochure' : 'Save new brochure';
    });

    for (const eventName of ['dragenter', 'dragover']) {
        dropzone.addEventListener(eventName, () => dropzone.classList.add('is-dragging'));
    }
    for (const eventName of ['dragleave', 'drop']) {
        dropzone.addEventListener(eventName, () => dropzone.classList.remove('is-dragging'));
    }

    form.addEventListener('submit', event => {
        if (input.files?.length || remove?.checked) return;
        event.preventDefault();
        showSelection('Choose a PDF before saving.', true);
        input.focus();
    });
})();
