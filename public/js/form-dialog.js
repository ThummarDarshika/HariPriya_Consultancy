(() => {
    'use strict';
    const dialog = document.querySelector('[data-form-dialog]');
    if (!dialog) return;
    const body = dialog.querySelector('[data-form-dialog-body]');
    const submit = dialog.querySelector('[data-form-dialog-save]');
    let form = null;
    let request = null;
    let busy = false;
    let editing = false;
    let saveLabel = 'Save changes';

    function disposeForm() {
        if (form) {
            form.querySelectorAll('input[type="file"]').forEach(input => {
                input.dataset.currentImage = '';
                input.dispatchEvent(new CustomEvent('image-upload:reset', { bubbles: true }));
            });
        }
        form = null;
        body.replaceChildren();
    }
    function closeDialog() {
        request?.abort();
        disposeForm();
        document.body.classList.remove('company-dialog-open');
        dialog.close();
    }
    function clearErrors() {
        form.querySelectorAll('[data-dialog-error], .jquery-validation-error').forEach(error => error.remove());
        form.querySelectorAll('[aria-invalid]').forEach(field => field.removeAttribute('aria-invalid'));
    }
    function showError(key, message) {
        const field = Array.from(form.elements).find(element => element.name?.replace(/\[([^\]]*)\]/g, '.$1') === key);
        const error = document.createElement('p');
        error.className = 'company-dialog__error';
        error.dataset.dialogError = key;
        error.setAttribute('role', 'alert');
        error.textContent = message;
        if (field) {
            field.setAttribute('aria-invalid', 'true');
            const label = field.closest('label');
            if (label) label.append(error);
            else field.after(error);
        } else form.prepend(error);
    }
    function focusError() {
        const field = form.querySelector('[aria-invalid="true"]');
        const focus = field?.type === 'file' ? field.nextElementSibling : field;
        if (focus) {
            focus.scrollIntoView({ block: 'center' });
            focus.focus({ preventScroll: true });
        } else form.querySelector('[data-dialog-error]')?.scrollIntoView({ block: 'center' });
    }
    function validate() {
        clearErrors();
        for (const field of form.querySelectorAll('input:not([type="hidden"]), textarea, select')) {
            if (field.disabled) continue;
            const label = field.closest('label')?.firstChild?.textContent?.replace('*', '').trim() || 'This field';
            const empty = field.type === 'file' ? !field.files.length && !field.dataset.hasExistingImage : !field.value.trim();
            if (field.hasAttribute('data-jquery-required') && empty) showError(field.name.replace(/\[([^\]]*)\]/g, '.$1'), `${label} is required.`);
            else if (field.value && field.validity.typeMismatch) showError(field.name.replace(/\[([^\]]*)\]/g, '.$1'), 'Enter a valid value.');
            else if (field.validity.rangeUnderflow || field.validity.rangeOverflow || field.validity.stepMismatch) showError(field.name.replace(/\[([^\]]*)\]/g, '.$1'), 'Enter a value within the allowed range.');
        }
        if (form.querySelector('[data-dialog-error]')) { focusError(); return false; }
        return true;
    }
    async function save(event) {
        event.preventDefault();
        if (busy || form.dataset.cropPending || !validate()) return;
        busy = true;
        submit.disabled = true;
        try {
            if (editing) {
                const confirmed = window.Swal ? (await window.Swal.fire({ target: dialog, title: 'Save changes?', icon: 'question', showCancelButton: true, confirmButtonText: 'Save changes', confirmButtonColor: '#c9441b' })).isConfirmed : window.confirm('Save changes?');
                if (!confirmed) return;
            }
            submit.textContent = 'Saving…';
            form.setAttribute('aria-busy', 'true');
            const response = await fetch(form.action, {
                method: 'POST', body: new FormData(form), credentials: 'same-origin',
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value },
            });
            const result = await response.json().catch(() => null);
            if (response.status === 422 && result?.errors) {
                for (const [field, messages] of Object.entries(result.errors)) showError(field, messages[0]);
                focusError();
                return;
            }
            if (!response.ok || (!result?.id && !result?.message)) throw new Error([401, 419].includes(response.status) || response.redirected ? 'Your session expired. Refresh the page and sign in again.' : 'Changes could not be saved. Please try again.');
            closeDialog();
            window.location.reload();
        } catch (error) {
            if (form) showError('form', error.message);
        } finally {
            busy = false;
            submit.disabled = false;
            submit.textContent = saveLabel;
            form?.removeAttribute('aria-busy');
        }
    }
    document.addEventListener('click', async event => {
        const link = event.target.closest('[data-form-dialog-open]');
        if (!link || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
        event.preventDefault();
        if (busy || form?.dataset.cropPending) return;
        request?.abort();
        disposeForm();
        const controller = new AbortController();
        request = controller;
        dialog.querySelector('h2').textContent = link.dataset.dialogTitle || 'Edit item';
        submit.disabled = true;
        body.textContent = 'Loading form…';
        body.setAttribute('aria-busy', 'true');
        document.body.classList.add('company-dialog-open');
        if (!dialog.open) dialog.showModal();
        try {
            const response = await fetch(link.href, { credentials: 'same-origin', signal: controller.signal, headers: { Accept: 'text/html' } });
            if (!response.ok || response.redirected) throw new Error('Form could not load. Refresh the page and sign in again.');
            const html = new DOMParser().parseFromString(await response.text(), 'text/html');
            const source = html.querySelector('form[data-jquery-validation]');
            if (!source) throw new Error('Form could not load. Please refresh and try again.');
            if (controller.signal.aborted || request !== controller || !dialog.open) return;
            editing = source.hasAttribute('data-admin-confirm-update');
            saveLabel = editing ? 'Save changes' : link.dataset.dialogTitle || 'Add item';
            form = document.importNode(source, true);
            form.id = 'content-dialog-form';
            form.className = 'content-dialog__form';
            for (const attribute of ['data-admin-confirm-update', 'data-admin-confirm-remove', 'data-jquery-validation']) form.removeAttribute(attribute);
            form.querySelector('.admin-form-actions')?.remove();
            body.replaceChildren(form);
            form.dispatchEvent(new CustomEvent('image-upload:mount', { bubbles: true }));
            form.addEventListener('submit', save);
            submit.textContent = saveLabel;
            submit.disabled = false;
            form.querySelector('.image-upload-tile, input:not([type="hidden"]):not([type="file"]), textarea, select')?.focus({ preventScroll: true });
        } catch (error) {
            if (error.name !== 'AbortError' && request === controller && dialog.open) body.textContent = error.message;
        } finally {
            if (request === controller) body.removeAttribute('aria-busy');
        }
    });
    dialog.querySelectorAll('[data-form-dialog-close]').forEach(button => button.addEventListener('click', () => {
        if (!busy && !form?.dataset.cropPending) closeDialog();
    }));
    dialog.addEventListener('cancel', event => {
        event.preventDefault();
        if (!busy && !form?.dataset.cropPending) closeDialog();
    });
    dialog.addEventListener('close', () => {
        if (dialog.open) return;
        request?.abort();
        disposeForm();
        document.body.classList.remove('company-dialog-open');
    });
})();
