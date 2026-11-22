(() => {
    'use strict';
    const dialog = document.querySelector('[data-project-dialog]');
    if (!dialog) return;
    const form = dialog.querySelector('[data-project-form]');
    const title = form.elements.namedItem('title');
    const image = form.querySelector('[data-project-image]');
    const videoInput = form.querySelector('[data-project-video]');
    const imageField = form.querySelector('[data-project-image-field]');
    const videoField = form.querySelector('[data-project-video-field]');
    const videoPreview = form.querySelector('[data-project-video-preview]');
    const video = videoPreview.querySelector('video');
    const videoPicker = form.querySelector('[data-project-video-select]');
    const count = form.querySelector('[data-project-image-count]');
    const submit = form.querySelector('[type="submit"]');
    let editing = false;
    let kind = 'image';
    let savedPath = '';
    let busy = false;
    let videoUrl = null;
    let acceptedFiles = [];
    const input = () => kind === 'image' ? image : videoInput;

    function clearErrors() {
        form.querySelectorAll('[data-project-error]').forEach(error => { error.textContent = ''; error.hidden = true; });
        form.querySelectorAll('[aria-invalid]').forEach(field => field.removeAttribute('aria-invalid'));
    }
    function showError(field, message) {
        const key = field.startsWith('media_upload') || field === 'media_type' ? 'media_upload' : field;
        const error = Array.from(form.querySelectorAll('[data-project-error]')).find(element => element.dataset.projectError === key) || form.querySelector('[data-project-error="form"]');
        error.textContent = message;
        error.hidden = false;
        if (key === 'title') title.setAttribute('aria-invalid', 'true');
        if (key === 'media_upload') input().setAttribute('aria-invalid', 'true');
    }
    function updateVideo(url = '') {
        video.pause();
        if (url) video.src = url;
        else video.removeAttribute('src');
        video.load();
        videoPreview.hidden = !url;
        videoPicker.classList.toggle('has-video', Boolean(url));
        videoPicker.querySelector('span').textContent = url ? 'Replace video' : 'Select video';
    }
    function resetFiles() {
        image.dataset.currentImage = '';
        image.dispatchEvent(new CustomEvent('image-upload:reset', { bubbles: true }));
        videoInput.value = '';
        acceptedFiles = [];
        updateVideo();
        if (videoUrl) URL.revokeObjectURL(videoUrl);
        videoUrl = null;
        count.hidden = true;
    }
    function validateFiles(files, required = false) {
        if (!files.length) return required ? `Select a project ${kind}.` : '';
        if (files.length > (image.multiple && kind === 'image' ? 20 : 1)) return 'Choose up to 20 images at a time.';
        const extensions = kind === 'image' ? ['jpg', 'jpeg', 'png', 'webp', 'gif'] : ['mp4', 'webm', 'ogg', 'ogv'];
        const types = kind === 'image' ? ['image/jpeg', 'image/png', 'image/webp', 'image/gif'] : ['video/mp4', 'video/webm', 'video/ogg'];
        for (const file of files) {
            if (!extensions.includes(file.name.split('.').pop().toLowerCase()) || (file.type && file.type !== 'application/octet-stream' && !types.includes(file.type))) return `Choose a supported ${kind} file.`;
            if (file.size > Number(input().dataset.maxBytes)) return `The maximum ${kind} size is ${Number(input().dataset.maxBytes) / 1048576} MB.`;
        }
        return '';
    }
    document.addEventListener('click', event => {
        const link = event.target.closest('[data-project-open]');
        if (!link || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
        event.preventDefault();
        if (busy) return;
        form.reset();
        resetFiles();
        clearErrors();
        editing = Boolean(link.dataset.projectAction);
        kind = link.dataset.projectKind === 'video' ? 'video' : 'image';
        savedPath = link.dataset.projectFile || '';
        form.action = link.dataset.projectAction || form.dataset.createUrl;
        form.elements.namedItem('_method').value = editing ? 'PUT' : 'POST';
        form.elements.namedItem('media_type').value = kind;
        title.value = link.dataset.projectTitle || '';
        image.disabled = kind !== 'image';
        videoInput.disabled = kind !== 'video';
        imageField.hidden = kind !== 'image';
        videoField.hidden = kind !== 'video';
        image.multiple = !editing;
        image.name = editing ? 'media_upload' : 'media_upload[]';
        image.dataset.currentImage = kind === 'image' ? savedPath : '';
        image.dispatchEvent(new CustomEvent('image-upload:reset', { bubbles: true }));
        if (kind === 'video') updateVideo(savedPath);
        dialog.querySelector('h2').textContent = editing ? 'Edit project' : 'Add project';
        submit.textContent = editing ? 'Save changes' : 'Add project';
        document.body.classList.add('company-dialog-open');
        dialog.showModal();
        (kind === 'image' ? image.nextElementSibling : videoPicker).focus({ preventScroll: true });
    });
    window.addEventListener('change', event => {
        if (event.target !== input() || !dialog.open) return;
        const message = validateFiles(Array.from(input().files));
        if (!message) return;
        event.stopImmediatePropagation();
        const transfer = new DataTransfer();
        acceptedFiles.forEach(file => transfer.items.add(file));
        input().files = transfer.files;
        showError('media_upload', message);
    }, true);
    form.addEventListener('change', event => {
        if (event.target !== input()) return;
        clearErrors();
        acceptedFiles = Array.from(input().files);
        if (kind === 'image') {
            count.hidden = acceptedFiles.length < 2;
            count.textContent = `${acceptedFiles.length} images`;
        } else {
            if (videoUrl) URL.revokeObjectURL(videoUrl);
            videoUrl = acceptedFiles[0] ? URL.createObjectURL(acceptedFiles[0]) : null;
            updateVideo(videoUrl || savedPath);
        }
    });
    videoPicker.addEventListener('click', () => videoInput.click());
    dialog.querySelectorAll('[data-project-close]').forEach(button => button.addEventListener('click', () => {
        if (!busy && !form.dataset.cropPending) dialog.close();
    }));
    dialog.addEventListener('cancel', event => {
        if (busy || form.dataset.cropPending) event.preventDefault();
    });
    dialog.addEventListener('close', () => {
        document.body.classList.remove('company-dialog-open');
        resetFiles();
    });
    form.addEventListener('submit', async event => {
        event.preventDefault();
        if (busy || form.dataset.cropPending) return;
        clearErrors();
        if (!title.value.trim()) showError('title', 'Enter the project title.');
        const message = validateFiles(Array.from(input().files), !savedPath);
        if (message) showError('media_upload', message);
        const invalid = form.querySelector('[aria-invalid="true"]');
        if (invalid) { (invalid === image ? image.nextElementSibling : invalid === videoInput ? videoPicker : invalid).focus(); return; }
        busy = true;
        submit.disabled = true;
        try {
            if (editing) {
                const confirmed = window.Swal ? (await window.Swal.fire({ target: dialog, title: 'Save changes?', text: `Save the changes to "${title.value.trim()}"?`, icon: 'question', showCancelButton: true, confirmButtonText: 'Save changes', confirmButtonColor: '#c9441b' })).isConfirmed : window.confirm('Save project changes?');
                if (!confirmed) return;
            }
            submit.textContent = 'Saving…';
            form.setAttribute('aria-busy', 'true');
            const response = await fetch(form.action, { method: 'POST', body: new FormData(form), credentials: 'same-origin', headers: { Accept: 'application/json', 'X-CSRF-TOKEN': form.elements.namedItem('_token').value } });
            const result = await response.json().catch(() => null);
            if (response.status === 422 && result?.errors) {
                for (const [field, messages] of Object.entries(result.errors)) showError(field, messages[0]);
                return;
            }
            if (!response.ok || !result?.message) throw new Error([401, 419].includes(response.status) || response.redirected ? 'Your session expired. Refresh the page and sign in again.' : 'Project could not be saved. Please try again.');
            dialog.close();
            window.location.reload();
        } catch (error) {
            showError('form', error.message);
        } finally {
            busy = false;
            submit.disabled = false;
            submit.textContent = editing ? 'Save changes' : 'Add project';
            form.removeAttribute('aria-busy');
        }
    });
})();
