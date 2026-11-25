(() => {
    'use strict';

    const form = document.querySelector('[data-bulk-delete-form]');
    const selectAll = document.querySelector('[data-bulk-select-all]');
    const getItems = () => Array.from(document.querySelectorAll('[data-bulk-select-item]'));

    function syncState() {
        const items = getItems();
        const selectedCount = items.filter(item => {
            item.closest('tr')?.classList.toggle('is-selected', item.checked);

            return item.checked;
        }).length;

        if (selectAll) {
            selectAll.disabled = items.length === 0;
            selectAll.checked = items.length > 0 && selectedCount === items.length;
            selectAll.indeterminate = selectedCount > 0 && selectedCount < items.length;
        }

        if (!form) {
            return;
        }

        const countLabel = form.querySelector('[data-bulk-count]');
        const deleteButton = form.querySelector('[data-bulk-delete-button]');

        if (countLabel) {
            countLabel.textContent = `${selectedCount} selected`;
        }

        if (deleteButton) {
            deleteButton.disabled = selectedCount === 0;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', () => {
            const checked = selectAll.checked;
            getItems().forEach(item => {
                item.checked = checked;
            });
            syncState();
        });
    }

    document.addEventListener('change', event => {
        if (event.target instanceof HTMLInputElement && event.target.matches('[data-bulk-select-item]')) {
            syncState();
        }
    });

    if (form) {
        form.addEventListener('submit', async event => {
            if (form.dataset.bulkConfirmed === 'true') {
                return;
            }

            const selectedCount = getItems().filter(item => item.checked).length;
            if (selectedCount === 0) {
                event.preventDefault();

                return;
            }

            event.preventDefault();
            const singular = form.dataset.bulkSingular || 'item';
            const plural = form.dataset.bulkPlural || 'items';
            const noun = selectedCount === 1 ? singular : plural;
            const title = `Delete selected ${plural}?`;
            const text = `Delete ${selectedCount} selected ${noun}?`;

            const confirmed = window.Swal
                ? (await window.Swal.fire({
                    title,
                    text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#b42318',
                    reverseButtons: true,
                })).isConfirmed
                : window.confirm(`${title}\n${text}`);

            if (!confirmed) {
                return;
            }

            form.dataset.bulkConfirmed = 'true';
            form.requestSubmit();
            setTimeout(() => delete form.dataset.bulkConfirmed, 0);
        });
    }

    window.addEventListener('pageshow', syncState);
    syncState();
})();

