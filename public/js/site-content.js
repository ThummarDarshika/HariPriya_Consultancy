(() => {
    'use strict';

    const page = document.querySelector('meta[name="cms-page"]')?.content || 'home';
    const endpoint = document.querySelector('meta[name="cms-content-url"]')?.content;
    const entries = new Map();
    const editableRoots = [document.querySelector('header'), document.querySelector('main'), document.querySelector('footer')].filter(Boolean);

    function ignored(element) {
        return Boolean(element.closest('[data-cms-collection], [data-cms-ignore], script, style, noscript, template, svg'));
    }

    function elementPath(element, root) {
        const parts = [];
        for (let current = element; current && current !== root; current = current.parentElement) {
            const siblings = Array.from(current.parentElement.children).filter(child => child.tagName === current.tagName);
            parts.unshift(`${current.tagName.toLowerCase()}:${siblings.indexOf(current)}`);
        }
        return parts.join('/');
    }

    function register(root, scope) {
        const rootName = root.tagName.toLowerCase();
        const elements = [root, ...root.querySelectorAll('*')];

        for (const element of elements) {
            if (ignored(element)) continue;

            const path = `${scope}/${rootName}/${elementPath(element, root)}`;
            const sharedKey = element.getAttribute('data-cms-shared-key');
            const entryScope = sharedKey ? 'global' : scope;
            const directText = Array.from(element.childNodes).filter(node => node.nodeType === Node.TEXT_NODE && node.nodeValue.trim());

            for (const node of directText) {
                const textIndex = Array.from(element.childNodes).filter(child => child.nodeType === Node.TEXT_NODE).indexOf(node);
                const key = sharedKey || `${path}/text:${textIndex}`;
                const type = !sharedKey && (/^(P|BLOCKQUOTE)$/.test(element.tagName) || node.nodeValue.trim().length > 80) ? 'textarea' : 'text';
                const entry = { key, scope: entryScope, type, node, element, original: node.nodeValue };
                entries.set(key, entry);
                if (!element.hasAttribute('data-key')) {
                    element.setAttribute('data-key', key);
                    element.setAttribute('data-type', type);
                }
            }

            if (element.tagName === 'IMG' && !element.hasAttribute('data-cms-managed-asset')) {
                const key = sharedKey || `${path}/image`;
                entries.set(key, { key, scope: entryScope, type: 'image', element, original: element.src, originalVisibility: element.style.visibility });
                element.setAttribute('data-cms-image', key);
            }

            if (element.tagName === 'VIDEO' && !element.hasAttribute('data-cms-managed-asset')) {
                const key = sharedKey || `${path}/video`;
                entries.set(key, { key, scope: entryScope, type: 'video', element, original: element.currentSrc || element.querySelector('source')?.src || element.src });
                element.setAttribute('data-cms-video', key);
            }

            if (element.hasAttribute('placeholder') && element.getAttribute('placeholder').trim()) {
                const key = `${path}/placeholder`;
                entries.set(key, { key, scope, type: 'text', attribute: 'placeholder', element, original: element.getAttribute('placeholder') });
                element.setAttribute('data-cms-placeholder', key);
            }

            if (scope === 'global' && element.tagName === 'A' && element.hasAttribute('href')) {
                const key = `${path}/href`;
                entries.set(key, { key, scope, type: 'url', attribute: 'href', element, original: element.getAttribute('href') });
                element.setAttribute('data-cms-href', key);
            }

            if (element.tagName !== 'VIDEO' && !element.hasAttribute('data-cms-managed-asset') && ((element.className && typeof element.className === 'string' && element.className.includes('bg-[url(')) || element.style?.backgroundImage?.includes('url('))) {
                const key = `${path}/background`;
                entries.set(key, { key, scope, type: 'background', element, original: element.style.backgroundImage });
                element.setAttribute('data-cms-background', key);
            }
        }
    }

    function apply(entry, value) {
        if (entry.type === 'video') {
            entry.element.src = value;
            entry.element.load();
        } else if (entry.type === 'image') {
            if (entry.element.getAttribute('src') === value) return;
            const request = Symbol();
            entry.imageRequest = request;
            entry.element.style.visibility = 'hidden';
            const reveal = () => {
                if (entry.imageRequest === request) entry.element.style.visibility = entry.originalVisibility;
            };
            entry.element.addEventListener('load', reveal, { once: true });
            entry.element.addEventListener('error', reveal, { once: true });
            entry.element.src = value;
            if (entry.element.complete) reveal();
        } else if (entry.type === 'background') {
            const request = Symbol();
            entry.imageRequest = request;
            entry.element.style.backgroundImage = 'none';
            const preload = new Image();
            const showBackground = () => {
                if (entry.imageRequest === request) entry.element.style.backgroundImage = `url(${JSON.stringify(value)})`;
            };
            preload.addEventListener('load', showBackground, { once: true });
            preload.addEventListener('error', showBackground, { once: true });
            preload.src = value;
            if (preload.complete) showBackground();
        } else if (entry.attribute) entry.element.setAttribute(entry.attribute, value);
        else entry.node.nodeValue = value;
    }

    for (const root of editableRoots) register(root, root.tagName === 'MAIN' ? page : 'global');

    window.SiteContent = { page, entries, apply, ready: false };

    function applyRecords(records) {
        for (const record of records) {
            const entry = entries.get(record.key);
            if (entry && entry.scope === record.page && entry.type === record.type) apply(entry, record.value);
        }
    }

    function markReady(eventName = 'site-content:ready') {
        window.SiteContent.ready = true;
        document.documentElement.classList.remove('cms-content-pending');
        document.dispatchEvent(new CustomEvent(eventName));
    }

    if (Array.isArray(window.siteContentInitial)) {
        applyRecords(window.siteContentInitial);
        markReady();
        return;
    }

    if (!endpoint) {
        markReady();
        return;
    }

    fetch(`${endpoint}?page=${encodeURIComponent(page)}`, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
        .then(response => {
            if (!response.ok) throw new Error('Unable to load site content');
            return response.json();
        })
        .then(records => {
            applyRecords(records);
            markReady();
        })
        .catch(() => markReady('site-content:error'));
})();
