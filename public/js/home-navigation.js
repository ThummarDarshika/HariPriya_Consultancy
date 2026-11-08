(() => {
    document.addEventListener('click', (event) => {
        const link = event.target.closest?.('[data-site-home-link]');
        if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

        if (window.location.pathname === '/') {
            event.preventDefault();
            window.scrollTo(0, 0);
            return;
        }

        if (document.referrer && new URL(document.referrer).origin === window.location.origin && new URL(document.referrer).pathname === '/' && window.history.length > 1) {
            event.preventDefault();
            window.history.back();
        }
    });
})();
