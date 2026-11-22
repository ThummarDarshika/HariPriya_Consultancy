(() => {
    const root = document.querySelector('[data-list-order]');
    if (!root || root.dataset.enabled !== 'true') return;
    const body = root.querySelector('tbody');
    const status = document.querySelector('[data-list-order-status]');
    let active = null;
    let previous = [];
    let saving = false;
    let pointer = null;
    let dragging = false;
    let suppressClick = false;
    let preview = null;
    let scrollFrame = null;
    const rows = () => Array.from(body.querySelectorAll('[data-order-id]'));
    rows().forEach(row => {
        row.tabIndex = 0;
        row.setAttribute('aria-keyshortcuts', 'ArrowUp ArrowDown');
    });
    const isControl = target => Boolean(target.closest('a, button, input, select, textarea, video, audio, [contenteditable]'));
    function restore() { previous.forEach(row => body.append(row)); }
    function updateDrag() {
        if (!dragging || !pointer || !preview) return;
        preview.style.transform = `translateY(${pointer.lastY - pointer.y}px)`;
        const target = document.elementFromPoint(pointer.lastX, pointer.lastY)?.closest('[data-order-id]');
        if (!target || target === active || !body.contains(target)) return;
        const rect = target.getBoundingClientRect();
        body.insertBefore(active, pointer.lastY < rect.top + rect.height / 2 ? target : target.nextSibling);
    }
    function scrollWhileDragging() {
        if (!dragging || !pointer) return;
        const edge = 80;
        const amount = pointer.lastY < edge ? -Math.ceil((edge - pointer.lastY) / 4)
            : pointer.lastY > window.innerHeight - edge ? Math.ceil((pointer.lastY - window.innerHeight + edge) / 4) : 0;
        if (amount) {
            window.scrollBy(0, Math.max(-24, Math.min(24, amount)));
            updateDrag();
        }
        scrollFrame = requestAnimationFrame(scrollWhileDragging);
    }
    function startDrag() {
        dragging = true;
        const rect = active.getBoundingClientRect();
        const table = document.createElement('table');
        table.className = 'admin-list__table';
        const clone = active.cloneNode(true);
        clone.removeAttribute('id');
        clone.removeAttribute('data-order-id');
        clone.removeAttribute('tabindex');
        clone.classList.remove('is-drag-ready');
        clone.querySelectorAll('[id]').forEach(element => element.removeAttribute('id'));
        Array.from(clone.cells).forEach((cell, index) => {
            cell.style.boxSizing = 'border-box';
            cell.style.width = `${active.cells[index].getBoundingClientRect().width}px`;
        });
        const previewBody = document.createElement('tbody');
        previewBody.append(clone);
        table.append(previewBody);
        preview = document.createElement('div');
        preview.className = 'admin-list admin-order-ghost';
        preview.setAttribute('aria-hidden', 'true');
        preview.inert = true;
        preview.style.top = `${rect.top}px`;
        preview.style.left = `${rect.left}px`;
        preview.style.width = `${rect.width}px`;
        preview.append(table);
        document.body.append(preview);
        active.classList.add('is-dragging');
        scrollFrame = requestAnimationFrame(scrollWhileDragging);
    }
    async function save() {
        saving = true;
        root.setAttribute('aria-busy', 'true');
        status.textContent = 'Saving order…';
        try {
            const response = await fetch(root.dataset.url, {
                method: 'POST', credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': root.dataset.token },
                body: JSON.stringify({ ids: rows().map(row => Number(row.dataset.orderId)) }),
            });
            if (!response.ok) throw new Error();
            status.textContent = 'Order saved.';
        } catch {
            restore();
            status.textContent = 'Order could not be saved. Reload the page and try again.';
        } finally {
            saving = false;
            root.removeAttribute('aria-busy');
        }
    }
    root.addEventListener('pointerdown', event => {
        const row = event.target.closest('[data-order-id]');
        if (!row || !body.contains(row) || saving || pointer || event.button !== 0 || isControl(event.target)) return;
        event.preventDefault();
        window.getSelection()?.removeAllRanges();
        previous = rows();
        active = row;
        pointer = { id: event.pointerId, x: event.clientX, y: event.clientY, lastX: event.clientX, lastY: event.clientY };
        dragging = false;
        active.classList.add('is-drag-ready');
        document.body.classList.add('admin-order-dragging');
        row.focus({ preventScroll: true });
        root.setPointerCapture(event.pointerId);
    });
    root.addEventListener('pointermove', event => {
        if (!active || event.pointerId !== pointer?.id) return;
        if (!dragging && Math.hypot(event.clientX - pointer.x, event.clientY - pointer.y) < 6) return;
        event.preventDefault();
        if (!dragging) startDrag();
        pointer.lastX = event.clientX;
        pointer.lastY = event.clientY;
        updateDrag();
    });
    function finishPointer(cancel = false) {
        if (!active) return;
        const row = active;
        row.classList.remove('is-drag-ready', 'is-dragging');
        document.body.classList.remove('admin-order-dragging');
        preview?.remove();
        preview = null;
        cancelAnimationFrame(scrollFrame);
        scrollFrame = null;
        const didDrag = dragging;
        const pointerId = pointer.id;
        active = null;
        pointer = null;
        dragging = false;
        if (root.hasPointerCapture(pointerId)) root.releasePointerCapture(pointerId);
        if (cancel) restore();
        else if (didDrag && rows().some((item, index) => item !== previous[index])) save();
        if (didDrag) {
            suppressClick = true;
            setTimeout(() => { suppressClick = false; }, 0);
        }
    }
    root.addEventListener('pointerup', event => {
        if (event.pointerId === pointer?.id) finishPointer();
    });
    root.addEventListener('pointercancel', event => {
        if (event.pointerId === pointer?.id) finishPointer(true);
    });
    root.addEventListener('lostpointercapture', () => { if (active) finishPointer(true); });
    window.addEventListener('blur', () => finishPointer(true));
    root.addEventListener('dragstart', event => {
        if (active) event.preventDefault();
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && active) {
            event.preventDefault();
            finishPointer(true);
        }
    });
    root.addEventListener('click', event => {
        if (!suppressClick) return;
        event.preventDefault();
        event.stopPropagation();
        suppressClick = false;
    }, true);
    root.addEventListener('keydown', event => {
        const row = event.target.closest('[data-order-id]');
        if (!row || saving || isControl(event.target) || !['ArrowUp', 'ArrowDown'].includes(event.key)) return;
        event.preventDefault();
        previous = rows();
        const neighbor = event.key === 'ArrowUp' ? row.previousElementSibling : row.nextElementSibling;
        if (!neighbor) return;
        body.insertBefore(row, event.key === 'ArrowUp' ? neighbor : neighbor.nextSibling);
        row.focus({ preventScroll: true });
        save();
    });
})();
