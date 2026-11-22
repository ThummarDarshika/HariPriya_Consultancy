(() => {
    'use strict';
    const dialog = document.querySelector('[data-company-dialog]');
    if (!dialog) return;
    const itemLabel = dialog.dataset.itemLabel || 'company';
    const itemTitle = itemLabel.charAt(0).toUpperCase() + itemLabel.slice(1);
    const form = dialog.querySelector('[data-company-form]');
    const name = form.elements.namedItem('name');
    const image = form.elements.namedItem('image_upload');
    const submit = form.querySelector('[type="submit"]');
    let editing = false;
    let busy = false;

    function clearErrors() {
        form.querySelectorAll('[data-company-error]').forEach(error => { error.textContent = ''; error.hidden = true; });
        name.removeAttribute('aria-invalid');
        image.removeAttribute('aria-invalid');
    }
    function showError(field, message) {
        const error = Array.from(form.querySelectorAll('[data-company-error]')).find(element => element.dataset.companyError === field);
        if (error) { error.textContent = message; error.hidden = false; }
        if (field === 'name') name.setAttribute('aria-invalid', 'true');
        if (field === 'image_upload') image.setAttribute('aria-invalid', 'true');
    }
    document.addEventListener('click', event => {
        const link = event.target.closest('[data-company-open]');
        if (!link || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
        event.preventDefault();
        if (busy) return;
        form.reset();
        clearErrors();
        editing = Boolean(link.dataset.companyAction);
        form.action = link.dataset.companyAction || form.dataset.createUrl;
        form.elements.namedItem('_method').value = editing ? 'PUT' : 'POST';
        name.value = link.dataset.companyName || '';
        image.dataset.currentImage = link.dataset.companyImage || '';
        image.dispatchEvent(new CustomEvent('image-upload:reset', { bubbles: true }));
        dialog.querySelector('h2').textContent = editing ? `Edit ${itemLabel}` : `Add ${itemLabel}`;
        submit.textContent = editing ? 'Save changes' : `Add ${itemLabel}`;
        document.body.classList.add('company-dialog-open');
        dialog.showModal();
        (image.nextElementSibling?.matches('.image-upload-tile') ? image.nextElementSibling : name).focus({ preventScroll: true });
    });
    dialog.querySelectorAll('[data-company-close]').forEach(button => button.addEventListener('click', () => {
        if (!busy && !form.dataset.cropPending) dialog.close();
    }));
    dialog.addEventListener('cancel', event => {
        if (busy || form.dataset.cropPending) event.preventDefault();
    });
    dialog.addEventListener('close', () => {
        document.body.classList.remove('company-dialog-open');
        image.dispatchEvent(new CustomEvent('image-upload:reset', { bubbles: true }));
    });
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (busy || form.dataset.cropPending) return;
        clearErrors();
        if (!name.value.trim()) showError('name', `Enter the ${itemLabel} name.`);
        if (!image.files.length && !image.dataset.currentImage) showError('image_upload', `Select a ${itemLabel} image.`);
        const invalid = form.querySelector('[aria-invalid="true"]');
        if (invalid) { (invalid === image ? image.nextElementSibling : invalid).focus(); return; }
        busy = true;
        submit.disabled = true;
        try {
            if (editing) {
                const confirmed = window.Swal ? (await window.Swal.fire({ target: dialog, title: 'Save changes?', text: `Save the changes to "${name.value.trim()}"?`, icon: 'question', showCancelButton: true, confirmButtonText: 'Save changes', confirmButtonColor: '#c9441b' })).isConfirmed : window.confirm(`Save ${itemLabel} changes?`);
                if (!confirmed) return;
            }
            submit.textContent = 'Saving…';
            form.setAttribute('aria-busy', 'true');
            const response = await fetch(form.action, {
                method: 'POST', body: new FormData(form), credentials: 'same-origin',
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': form.elements.namedItem('_token').value },
            });
            const result = await response.json().catch(() => null);
            if (response.status === 422 && result?.errors) {
                for (const [field, messages] of Object.entries(result.errors)) showError(field, messages[0]);
                return;
            }
            if (!response.ok || !result?.message) throw new Error([401, 419].includes(response.status) || response.redirected ? 'Your session expired. Refresh the page and sign in again.' : `${itemTitle} could not be saved. Please try again.`);
            dialog.close();
            window.location.reload();
        } catch (error) {
            showError('form', error.message);
        } finally {
            busy = false;
            submit.disabled = false;
            submit.textContent = editing ? 'Save changes' : `Add ${itemLabel}`;
            form.removeAttribute('aria-busy');
        }
    });
})();
