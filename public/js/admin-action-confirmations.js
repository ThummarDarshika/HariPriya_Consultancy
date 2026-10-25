(() => {
    'use strict';

    async function confirmAction(options) {
        if (!window.Swal) {
            return window.confirm(`${options.title}\n${options.text}`);
        }

        const result = await window.Swal.fire({
            ...options,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        });

        return result.isConfirmed;
    }

    document.addEventListener('submit', async event => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || event.defaultPrevented || form.dataset.adminConfirmationApproved === 'true') return;

        const isDelete = form.hasAttribute('data-admin-confirm-delete');
        const isUpdate = form.hasAttribute('data-admin-confirm-update');
        const isRemove = Boolean(form.querySelector('input[name="remove"]:checked, input[name="remove_image"]:checked, input[name="clear_gallery"]:checked'));
        if (!isDelete && !isUpdate && !(form.hasAttribute('data-admin-confirm-remove') && isRemove)) return;

        event.preventDefault();
        const submitter = event.submitter;
        const label = form.dataset.adminConfirmLabel || 'this item';
        const confirmed = await confirmAction(isDelete || isRemove ? {
            title: isDelete ? 'Delete this item?' : 'Remove selected media?',
            text: isDelete ? `Delete "${label}"?` : `Remove the selected media from "${label}"?`,
            icon: 'warning',
            confirmButtonText: isDelete ? 'Delete' : 'Remove',
            confirmButtonColor: '#b42318',
        } : {
            title: 'Save changes?',
            text: `Save the changes to "${label}"?`,
            icon: 'question',
            confirmButtonText: 'Save changes',
            confirmButtonColor: '#c9441b',
        });

        if (!confirmed) return;

        form.dataset.adminConfirmationApproved = 'true';
        form.requestSubmit(submitter || undefined);
        setTimeout(() => delete form.dataset.adminConfirmationApproved, 0);
    });
})();
