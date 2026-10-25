(() => {
    'use strict';

    const fileInput = document.querySelector('[data-project-media-file]');
    const form = fileInput?.closest('form');
    const error = document.querySelector('[data-project-media-error]');
    if (!fileInput || !form || !error) return;

    const isVideo = fileInput.dataset.mediaKind === 'video';
    const allowedExtensions = isVideo ? ['mp4', 'webm', 'ogg', 'ogv'] : ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    const allowedMimeTypes = isVideo
        ? ['video/mp4', 'video/webm', 'video/ogg']
        : ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    const maximumBytes = Number(fileInput.dataset.maxBytes);
    const maximumMegabytes = maximumBytes / (1024 * 1024);
    const fileLabel = isVideo ? 'video' : 'image';

    function showError(message) {
        error.textContent = message;
        error.hidden = !message;
        if (message) fileInput.setAttribute('aria-invalid', 'true');
        else fileInput.removeAttribute('aria-invalid');
    }

    function validateFile() {
        const file = fileInput.files?.[0];
        if (!file) {
            const message = fileInput.dataset.requiresFile ? `Please choose a ${fileLabel} file.` : '';
            showError(message);
            return !message;
        }

        const extension = file.name.split('.').pop()?.toLowerCase();
        if (!allowedExtensions.includes(extension)) {
            showError(isVideo
                ? 'This video format is not supported. Choose an MP4, WebM, OGG or OGV file.'
                : 'This image format is not supported. Choose a JPG, JPEG, PNG, WebP or GIF file.');
            return false;
        }

        if (file.type && file.type !== 'application/octet-stream' && !allowedMimeTypes.includes(file.type)) {
            showError(`The selected file is not a valid ${fileLabel}. Choose a supported ${fileLabel} file.`);
            return false;
        }

        if (file.size > maximumBytes) {
            showError(`This ${fileLabel} is ${(file.size / (1024 * 1024)).toFixed(1)} MB. The maximum allowed size is ${maximumMegabytes} MB.`);
            return false;
        }

        showError('');
        return true;
    }

    fileInput.addEventListener('change', validateFile);
    form.addEventListener('submit', event => {
        if (!validateFile()) {
            event.preventDefault();
            fileInput.focus();
        }
    });
})();
