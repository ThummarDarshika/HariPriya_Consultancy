(() => {
    'use strict';

    const cms = window.SiteContent;
    if (!cms) return;
    document.body.classList.add('cms-editing');

    const maximumImageSize = 5 * 1024 * 1024;
    const maximumVideoSize = 8 * 1024 * 1024;
    const drafts = new Map();
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/png,image/jpeg,image/webp,image/gif';
    fileInput.hidden = true;
    fileInput.setAttribute('data-cms-ignore', '');
    document.body.append(fileInput);

    const videoFileInput = document.createElement('input');
    videoFileInput.type = 'file';
    videoFileInput.accept = 'video/mp4,video/webm,video/ogg';
    videoFileInput.hidden = true;
    videoFileInput.setAttribute('data-cms-ignore', '');
    document.body.append(videoFileInput);

    const imageAction = document.createElement('button');
    imageAction.type = 'button';
    imageAction.className = 'cms-image-action';
    imageAction.innerHTML = '<span aria-hidden="true">+</span>';
    imageAction.setAttribute('aria-label', 'Replace image');
    imageAction.setAttribute('data-cms-ignore', '');
    document.body.append(imageAction);

    const videoAction = document.createElement('button');
    videoAction.type = 'button';
    videoAction.className = 'cms-video-action';
    videoAction.innerHTML = '<span aria-hidden="true">▶</span><small>Replace video</small>';
    videoAction.setAttribute('aria-label', 'Replace video');
    videoAction.setAttribute('data-cms-ignore', '');
    videoAction.style.display = 'none';
    document.body.append(videoAction);

    const count = document.getElementById('cms-draft-count');
    const status = document.getElementById('cms-status');
    if (!cms.ready) status.textContent = 'Loading content…';
    document.addEventListener('site-content:ready', () => { status.textContent = ''; });
    document.addEventListener('site-content:error', () => { status.textContent = 'Content could not load'; });
    let activeImage = null;
    let activeVideo = null;
    let activeInput = null;
    let pointerPosition = null;

    function updateCount() {
        count.textContent = String(drafts.size);
    }

    function entryAtPoint(x, y, target) {
        const position = document.caretPositionFromPoint?.(x, y);
        let node = position?.offsetNode || document.caretRangeFromPoint?.(x, y)?.startContainer;
        if (node?.nodeType !== Node.TEXT_NODE) node = null;
        let entry = node && Array.from(cms.entries.values()).find(item => item.node === node);
        if (entry) return entry;
        entry = Array.from(cms.entries.values()).find(item => item.node && item.element === target);
        return entry || null;
    }

    function editText(entry) {
        if (activeInput || !entry.node.isConnected) return;
        const node = entry.node;
        const original = node.nodeValue;
        const leading = original.match(/^\s*/)[0];
        const trailing = original.match(/\s*$/)[0];
        const value = original.trim();
        const range = document.createRange();
        range.selectNodeContents(node);
        const bounds = range.getBoundingClientRect();
        const style = getComputedStyle(entry.element);
        const multiline = entry.type === 'textarea' || bounds.height > parseFloat(style.lineHeight || '0') * 1.5;
        const input = document.createElement(multiline ? 'textarea' : 'input');
        if (!multiline) input.type = 'text';
        input.className = 'cms-active-input';
        input.value = value;
        input.placeholder = 'Enter text';
        input.style.fontFamily = style.fontFamily;
        input.style.fontSize = style.fontSize;
        input.style.fontWeight = style.fontWeight;
        input.style.lineHeight = style.lineHeight;
        input.style.textAlign = style.textAlign;
        input.style.color = style.color;
        input.style.letterSpacing = style.letterSpacing;
        input.style.width = `${Math.max(bounds.width, 80)}px`;
        input.style.minHeight = `${Math.max(bounds.height, parseFloat(style.lineHeight) || 20)}px`;
        if (multiline) input.style.height = `${Math.max(bounds.height, 36)}px`;
        input.setAttribute('data-cms-ignore', '');
        node.replaceWith(input);
        activeInput = input;
        input.focus();
        input.select();

        let finished = false;
        function finish(cancel = false) {
            if (finished) return;
            finished = true;
            const nextValue = cancel ? value : input.value;
            node.nodeValue = `${leading}${nextValue}${trailing}`;
            input.replaceWith(node);
            activeInput = null;
            if (!cancel && nextValue !== value) {
                drafts.set(entry.key, { entry, value: node.nodeValue });
                for (const twin of cms.entries.values()) {
                    if (twin === entry || !twin.node || twin.scope !== entry.scope) continue;
                    if (twin.element.parentElement === entry.element.parentElement && twin.node.nodeValue.trim() === value) {
                        twin.node.nodeValue = `${twin.node.nodeValue.match(/^\s*/)[0]}${nextValue}${twin.node.nodeValue.match(/\s*$/)[0]}`;
                        drafts.set(twin.key, { entry: twin, value: twin.node.nodeValue });
                    }
                }
                updateCount();
            }
        }
        input.addEventListener('blur', () => finish());
        if (multiline) input.addEventListener('input', () => {
            input.style.height = 'auto';
            input.style.height = `${Math.max(bounds.height, input.scrollHeight)}px`;
        });
        input.addEventListener('keydown', event => {
            if (event.key === 'Escape') { event.preventDefault(); finish(true); }
            if (event.key === 'Enter' && (!multiline || event.ctrlKey)) { event.preventDefault(); finish(); }
        });
    }

    function editAttribute(entry) {
        if (activeInput) return;
        const original = entry.element.getAttribute(entry.attribute) || '';
        const bounds = entry.element.getBoundingClientRect();
        const style = getComputedStyle(entry.element);
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'cms-active-input';
        input.value = original;
        input.setAttribute('data-cms-ignore', '');
        Object.assign(input.style, {
            position: 'fixed', zIndex: '2147483645', left: `${bounds.left}px`, top: `${bounds.top}px`,
            width: `${bounds.width}px`, height: `${bounds.height}px`, fontFamily: style.fontFamily,
            fontSize: style.fontSize, fontWeight: style.fontWeight, textAlign: style.textAlign,
            color: style.color, background: style.backgroundColor,
        });
        document.body.append(input);
        activeInput = input;
        input.focus();
        input.select();
        let finished = false;
        function finish(cancel = false) {
            if (finished) return;
            finished = true;
            if (!cancel && input.value !== original) {
                cms.apply(entry, input.value);
                drafts.set(entry.key, { entry, value: input.value });
                updateCount();
            }
            input.remove();
            activeInput = null;
        }
        input.addEventListener('blur', () => finish());
        input.addEventListener('keydown', event => {
            if (event.key === 'Escape') { event.preventDefault(); finish(true); }
            if (event.key === 'Enter') { event.preventDefault(); finish(); }
        });
    }

    document.addEventListener('click', event => {
        if (event.target.closest('[data-project-pagination] a, [data-case-study-pagination] a')) return;
        const siteControl = event.target.closest('header a, header button, header [role="button"], main a, main button, main [role="button"], footer a, footer button, footer [role="button"]');
        if (siteControl) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (!cms.ready) return;
        if (event.target.closest('[data-cms-ignore], [data-cms-editor-ignore], [data-cms-collection]')) return;
        const placeholder = event.target.closest('[data-cms-placeholder]');
        if (placeholder) {
            event.preventDefault();
            event.stopPropagation();
            editAttribute(cms.entries.get(placeholder.dataset.cmsPlaceholder));
            return;
        }
        const link = event.altKey && event.target.closest('[data-cms-href]');
        if (link) {
            event.preventDefault();
            event.stopPropagation();
            editAttribute(cms.entries.get(link.dataset.cmsHref));
            return;
        }
        if (event.target.closest('input, textarea, select')) return;
        const entry = entryAtPoint(event.clientX, event.clientY, event.target);
        if (!entry) return;
        event.preventDefault();
        event.stopPropagation();
        editText(entry);
    }, true);

    document.addEventListener('submit', event => {
        if (event.target.closest('header, main, footer')) event.preventDefault();
    }, true);

    function positionImageAction(entry) {
        if (!entry || !entry.element.isConnected) { imageAction.style.display = 'none'; return; }
        const rect = entry.element.getBoundingClientRect();
        if (rect.width < 1 || rect.height < 1) { imageAction.style.display = 'none'; return; }
        const isBackground = entry.type === 'background';
        imageAction.style.left = `${isBackground ? rect.left + rect.width / 2 - 26 : rect.left}px`;
        imageAction.style.top = `${isBackground ? rect.top + rect.height / 2 - 26 : rect.top}px`;
        imageAction.style.width = `${isBackground ? 52 : rect.width}px`;
        imageAction.style.height = `${isBackground ? 52 : rect.height}px`;
        imageAction.style.display = 'flex';
    }

    function positionVideoAction(entry) {
        if (!entry || !entry.element.isConnected) { videoAction.style.display = 'none'; return; }
        const rect = entry.element.getBoundingClientRect();
        if (rect.width < 1 || rect.height < 1) { videoAction.style.display = 'none'; return; }
        videoAction.style.left = `${rect.left + rect.width / 2}px`;
        videoAction.style.top = `${rect.top + rect.height / 2}px`;
        videoAction.style.display = 'flex';
    }

    function updateMediaActions(target, x, y) {
        if (!cms.ready) return;
        if (target?.closest?.('[data-cms-ignore], [data-cms-editor-ignore]')) {
            activeImage = null;
            activeVideo = null;
            positionImageAction(null);
            positionVideoAction(null);
            return;
        }
        const video = target?.closest?.('[data-cms-video]');
        activeVideo = video ? cms.entries.get(video.getAttribute('data-cms-video')) : Array.from(cms.entries.values()).find(entry => {
            if (entry.type !== 'video' || !entry.element.isConnected) return false;
            const rect = entry.element.getBoundingClientRect();
            return x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom;
        }) || null;
        positionVideoAction(activeVideo);
        const image = target?.closest?.('[data-cms-image]') || (target?.hasAttribute?.('data-cms-background') ? target : null);
        activeImage = image ? cms.entries.get(image.getAttribute('data-cms-image') || image.getAttribute('data-cms-background')) : null;
        positionImageAction(activeImage);
    }

    function refreshMediaActionsAtPointer() {
        if (!pointerPosition) return;
        const imageVisibility = imageAction.style.visibility;
        const videoVisibility = videoAction.style.visibility;
        imageAction.style.visibility = 'hidden';
        videoAction.style.visibility = 'hidden';
        const target = document.elementFromPoint(pointerPosition.x, pointerPosition.y);
        imageAction.style.visibility = imageVisibility;
        videoAction.style.visibility = videoVisibility;
        updateMediaActions(target, pointerPosition.x, pointerPosition.y);
    }

    document.addEventListener('pointermove', event => {
        pointerPosition = { x: event.clientX, y: event.clientY };
        if (event.target === imageAction || imageAction.contains(event.target) || event.target === videoAction || videoAction.contains(event.target)) return;
        updateMediaActions(event.target, event.clientX, event.clientY);
    });
    window.addEventListener('scroll', () => requestAnimationFrame(refreshMediaActionsAtPointer), true);
    window.addEventListener('resize', () => requestAnimationFrame(refreshMediaActionsAtPointer));
    imageAction.addEventListener('pointerleave', () => { imageAction.style.display = 'none'; });
    videoAction.addEventListener('pointerleave', () => { videoAction.style.display = 'none'; });
    imageAction.addEventListener('click', () => fileInput.click());
    videoAction.addEventListener('click', () => videoFileInput.click());
    fileInput.addEventListener('change', () => {
        const file = fileInput.files?.[0];
        if (!file || !activeImage) return;
        if (file.size > maximumImageSize) {
            status.textContent = 'Image must be 5 MB or smaller.';
            fileInput.value = '';
            return;
        }
        const previous = drafts.get(activeImage.key);
        if (previous?.previewUrl) URL.revokeObjectURL(previous.previewUrl);
        const previewUrl = URL.createObjectURL(file);
        cms.apply(activeImage, previewUrl);
        drafts.set(activeImage.key, { entry: activeImage, file, previewUrl });
        updateCount();
        fileInput.value = '';
        positionImageAction(activeImage);
    });
    videoFileInput.addEventListener('change', () => {
        const file = videoFileInput.files?.[0];
        if (!file || !activeVideo) return;
        if (file.size > maximumVideoSize) {
            status.textContent = 'Video must be 8 MB or smaller.';
            videoFileInput.value = '';
            return;
        }
        const previous = drafts.get(activeVideo.key);
        if (previous?.previewUrl) URL.revokeObjectURL(previous.previewUrl);
        const previewUrl = URL.createObjectURL(file);
        cms.apply(activeVideo, previewUrl);
        drafts.set(activeVideo.key, { entry: activeVideo, file, previewUrl });
        updateCount();
        videoFileInput.value = '';
        positionVideoAction(activeVideo);
    });

    document.querySelectorAll('[data-cms-collection]').forEach(collection => {
        const badge = document.createElement('span');
        badge.className = 'cms-collection-badge';
        badge.textContent = 'Manage items in Admin Dashboard';
        badge.setAttribute('data-cms-ignore', '');
        const badgeHost = collection.classList.contains('swiper-wrapper') ? collection.parentElement : collection;
        badgeHost.style.position ||= 'relative';
        badgeHost.prepend(badge);
    });

    function clearDrafts() {
        for (const draft of drafts.values()) {
            if (draft.previewUrl) URL.revokeObjectURL(draft.previewUrl);
        }
        drafts.clear();
        updateCount();
    }

    async function confirmEditorAction(options) {
        if (!window.Swal) {
            return window.confirm(`${options.title}\n${options.text}`);
        }

        const result = await window.Swal.fire(options);
        return result.isConfirmed;
    }

    document.getElementById('cms-discard').addEventListener('click', async () => {
        const hasDrafts = drafts.size > 0;
        const confirmed = await confirmEditorAction({
            title: 'Discard edits?',
            text: hasDrafts ? `This will discard ${drafts.size} unsaved change${drafts.size === 1 ? '' : 's'}.` : 'There are no unsaved changes.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Discard edits',
            cancelButtonText: 'Keep editing',
            confirmButtonColor: '#dc2626',
            reverseButtons: true,
        });

        if (!confirmed || !hasDrafts) {
            return;
        }

        clearDrafts();
        location.reload();
    });
    document.getElementById('cms-page-switcher').addEventListener('change', event => {
        if (drafts.size && !confirm('Discard unsaved edits and switch page?')) {
            event.target.selectedIndex = Array.from(event.target.options).findIndex(option => option.defaultSelected);
            return;
        }
        clearDrafts();
        location.assign(event.target.value);
    });
    window.addEventListener('beforeunload', event => {
        if (!drafts.size) return;
        event.preventDefault();
        event.returnValue = '';
    });

    document.getElementById('cms-save').addEventListener('click', async () => {
        if (activeInput) activeInput.blur();
        const confirmed = await confirmEditorAction({
            title: 'Publish changes?',
            text: drafts.size ? `Publish ${drafts.size} pending change${drafts.size === 1 ? '' : 's'} to the live website?` : 'There are no changes waiting to be published.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Publish',
            cancelButtonText: 'Continue editing',
            confirmButtonColor: '#16a34a',
            reverseButtons: true,
        });

        if (!confirmed || !drafts.size) {
            return;
        }
        const saveUrl = document.querySelector('meta[name="cms-save-url"]').content;
        const button = document.getElementById('cms-save');
        button.disabled = true;
        status.textContent = 'Saving…';
        try {
            for (const scope of [cms.page, 'global']) {
                const pending = Array.from(drafts.values()).filter(draft => draft.entry.scope === scope);
                if (!pending.length) continue;
                const textDrafts = pending.filter(draft => !draft.file);
                const fileDrafts = pending.filter(draft => draft.file);
                const batches = [{ type: 'changes', drafts: textDrafts }, ...fileDrafts.map(draft => ({ type: draft.entry.type === 'video' ? 'videos' : 'images', drafts: [draft] }))].filter(batch => batch.drafts.length);
                for (const batch of batches) {
                    const data = new FormData();
                    data.append('page', scope);
                    batch.drafts.forEach((draft, index) => {
                        if (draft.file) {
                            data.append(`${batch.type}[${index}][key]`, draft.entry.key);
                            if (batch.type === 'images') data.append(`${batch.type}[${index}][type]`, draft.entry.type);
                            data.append(`${batch.type}[${index}][file]`, draft.file);
                        } else {
                            data.append(`changes[${index}][key]`, draft.entry.key);
                            data.append(`changes[${index}][type]`, draft.entry.type);
                            data.append(`changes[${index}][value]`, draft.value);
                        }
                    });
                    const response = await fetch(saveUrl, {
                        method: 'POST', credentials: 'same-origin', body: data,
                        headers: { Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    });
                    if (response.redirected && new URL(response.url).pathname.endsWith('/admin/login')) {
                        throw new Error('Admin session expired. Please log in again, then reopen the editor to publish.');
                    }
                    if (!response.headers.get('content-type')?.includes('application/json')) {
                        if (response.status === 413) throw new Error('The uploaded file is too large for the server.');
                        throw new Error(`The server returned a page instead of save data (HTTP ${response.status}). Refresh the editor and sign in again.`);
                    }
                    const result = await response.json().catch(() => null);
                    if (!response.ok) {
                        if (response.status === 419) {
                            throw new Error('Your admin session expired. Reload the editor and sign in again before publishing.');
                        }
                        const firstError = Object.values(result?.errors || {}).flat()[0];
                        throw new Error(firstError || result?.message || 'Save failed. Please try again.');
                    }
                    if (!Array.isArray(result?.saved)) {
                        throw new Error('Save failed. Please try again.');
                    }
                    for (const record of result.saved) {
                        const draft = drafts.get(record.key);
                        if (draft?.previewUrl) URL.revokeObjectURL(draft.previewUrl);
                        if (draft) cms.apply(draft.entry, record.value);
                        drafts.delete(record.key);
                    }
                }
            }
            updateCount();
            status.textContent = 'Published';
        } catch (error) {
            status.textContent = error.message;
        } finally {
            button.disabled = false;
        }
    });
})();
