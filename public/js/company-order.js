(() => {
    const root = document.querySelector('[data-company-order]');
    if (!root || root.dataset.enabled !== 'true') return;
    const body = root.querySelector('tbody');
    const status = document.querySelector('[data-company-order-status]');
    let active = null;
    let previous = [];
    let saving = false;
    const rows = () => Array.from(body.querySelectorAll('[data-company-id]'));
    function restore() { previous.forEach(row => body.append(row)); }
    async function save() {
        saving = true;
        root.querySelectorAll('[data-drag-handle]').forEach(button => button.disabled = true);
        status.textContent = 'Saving order…';
        try {
            const response = await fetch(root.dataset.url, {
                method: 'POST', credentials: 'same-origin',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': root.dataset.token },
                body: JSON.stringify({ ids: rows().map(row => Number(row.dataset.companyId)) }),
            });
            if (!response.ok) throw new Error();
            status.textContent = 'Order saved.';
        } catch {
            restore();
            status.textContent = 'Order could not be saved. Reload the page and try again.';
        } finally {
            saving = false;
            root.querySelectorAll('[data-drag-handle]').forEach(button => button.disabled = false);
        }
    }
    root.addEventListener('pointerdown', event => {
        const handle = event.target.closest('[data-drag-handle]');
        if (!handle || saving || event.button !== 0) return;
        previous = rows();
        active = handle.closest('tr');
        handle.setPointerCapture(event.pointerId);
        active.style.opacity = '.5';
        event.preventDefault();
    });
    root.addEventListener('pointermove', event => {
        if (!active) return;
        if (event.clientY < 80) window.scrollBy(0, -20);
        if (event.clientY > window.innerHeight - 80) window.scrollBy(0, 20);
        const target = document.elementFromPoint(event.clientX, event.clientY)?.closest('[data-company-id]');
        if (!target || target === active || !body.contains(target)) return;
        const rect = target.getBoundingClientRect();
        body.insertBefore(active, event.clientY < rect.top + rect.height / 2 ? target : target.nextSibling);
    });
    root.addEventListener('pointerup', () => {
        if (!active) return;
        active.style.opacity = '';
        active = null;
        if (rows().some((row, index) => row !== previous[index])) save();
    });
    root.addEventListener('pointercancel', () => {
        if (!active) return;
        active.style.opacity = '';
        active = null;
        restore();
    });
    root.addEventListener('keydown', event => {
        const handle = event.target.closest('[data-drag-handle]');
        if (!handle || saving || !['ArrowUp', 'ArrowDown'].includes(event.key)) return;
        event.preventDefault();
        previous = rows();
        const row = handle.closest('tr');
        const neighbor = event.key === 'ArrowUp' ? row.previousElementSibling : row.nextElementSibling;
        if (!neighbor) return;
        body.insertBefore(row, event.key === 'ArrowUp' ? neighbor : neighbor.nextSibling);
        save();
    });
})();
