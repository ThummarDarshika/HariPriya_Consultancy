(() => {
    'use strict';
    const root = document.querySelector('[data-admin-search]');
    if (!root) return;
    const bar = root.closest('.admin-page-bar');
    const form = root.querySelector('form');
    const toggle = root.querySelector('[data-search-toggle]');
    const input = form.querySelector('input');
    function setOpen(open, focus = false) {
        root.dataset.open = String(open);
        toggle.setAttribute('aria-expanded', String(open));
        bar.classList.toggle('is-search-open', open);
        form.hidden = !open;
        if (focus) {
            (open ? input : toggle).focus();
            if (open) input.select();
        }
    }
    setOpen(root.dataset.open === 'true');
    toggle.addEventListener('click', () => setOpen(form.hidden, true));
    root.querySelector('[data-search-close]').addEventListener('click', () => setOpen(false, true));
    form.addEventListener('keydown', event => {
        if (event.key === 'Escape') { event.preventDefault(); setOpen(false, true); }
    });
    document.addEventListener('click', event => {
        if (!root.contains(event.target)) setOpen(false);
        document.querySelectorAll('[data-add-menu][open]').forEach(menu => {
            if (!menu.contains(event.target) || event.target.closest('a')) menu.open = false;
        });
    });
    document.addEventListener('keydown', event => {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('[data-add-menu][open]').forEach(menu => {
            menu.open = false;
            menu.querySelector('summary').focus();
        });
    });
})();
