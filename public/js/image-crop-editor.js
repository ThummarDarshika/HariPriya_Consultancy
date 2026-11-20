(() => {
    'use strict';
    const approved = new WeakSet();
    let busy = false;
    document.querySelectorAll('input[type="file"][data-crop-width]').forEach(input => {
        if (input.dataset.mediaKind === 'video') return;
        const hint = document.createElement('small');
        hint.className = 'image-crop-hint';
        hint.textContent = `Saved image: ${input.dataset.cropWidth} × ${input.dataset.cropHeight} px. Select an image to adjust the crop, position and zoom.`;
        input.after(hint);
    });
    const dialog = document.createElement('dialog');
    dialog.className = 'image-crop-editor';
    dialog.setAttribute('data-cms-ignore', '');
    dialog.setAttribute('aria-labelledby', 'crop-heading');
    dialog.innerHTML = `<div class="image-crop-editor__heading"><h2 id="crop-heading">Adjust image</h2><button type="button" data-crop-cancel aria-label="Cancel image selection">×</button></div>
        <p data-crop-info></p><p>Drag to position. Use the wheel, pinch, or zoom buttons to resize. Empty space is saved as white.</p>
        <div class="image-crop-editor__workspace"><img alt="Image being adjusted" data-crop-image></div>
        <div class="image-crop-editor__tools"><button type="button" data-crop-zoom="-0.15">− Zoom out</button><button type="button" data-crop-zoom="0.15">+ Zoom in</button><button type="button" data-crop-fit>Fit whole image</button><button type="button" data-crop-reset>Reset</button></div>
        <div class="image-crop-editor__preview"><div><strong>Saved image preview</strong><p data-crop-size></p></div><canvas data-crop-preview></canvas></div>
        <p role="alert" data-crop-error></p><div class="image-crop-editor__actions"><button type="button" data-crop-cancel>Cancel selection</button><button type="button" data-crop-apply>Use this image</button></div>`;
    document.body.append(dialog);
    const image = dialog.querySelector('[data-crop-image]');
    const preview = dialog.querySelector('[data-crop-preview]');
    const applyButton = dialog.querySelector('[data-crop-apply]');

    function edit(file, options, index, total) {
        return new Promise(resolve => {
            let cropper;
            let width;
            let height;
            let frame;
            let ready = false;
            let finished = false;
            const source = URL.createObjectURL(file);
            const error = dialog.querySelector('[data-crop-error]');
            error.textContent = '';
            applyButton.disabled = true;
            function render() {
                cancelAnimationFrame(frame);
                frame = requestAnimationFrame(() => {
                    if (!ready) return;
                    const canvas = cropper.getCroppedCanvas({ width: Math.min(width, 420), height: Math.min(width, 420) * height / width, fillColor: '#fff' });
                    if (!canvas) return;
                    preview.width = canvas.width;
                    preview.height = canvas.height;
                    preview.getContext('2d').drawImage(canvas, 0, 0);
                });
            }
            function finish(result) {
                if (finished) return;
                finished = true;
                ready = false;
                cancelAnimationFrame(frame);
                cropper?.destroy();
                URL.revokeObjectURL(source);
                dialog.close();
                dialog.oncancel = null;
                dialog.onclick = null;
                image.onerror = null;
                resolve(result);
            }
            function fit() {
                const box = cropper.getCropBoxData();
                const original = cropper.getImageData();
                const scale = Math.min(box.width / original.naturalWidth, box.height / original.naturalHeight);
                const w = original.naturalWidth * scale;
                const h = original.naturalHeight * scale;
                cropper.setCanvasData({ width: w });
                cropper.moveTo(box.left + (box.width - w) / 2, box.top + (box.height - h) / 2);
            }
            image.onerror = () => { error.textContent = 'This image could not be opened. Cancel and choose another file.'; };
            image.src = source;
            dialog.showModal();
            cropper = new Cropper(image, {
                viewMode: 0, dragMode: 'move', background: false, autoCropArea: .85,
                cropBoxMovable: false, cropBoxResizable: false, toggleDragModeOnDblclick: false,
                ready() {
                    const original = this.cropper.getImageData();
                    width = Number(options.width) || Math.min(original.naturalWidth, 1920);
                    height = Number(options.height) || Math.round(width * original.naturalHeight / original.naturalWidth);
                    this.cropper.setAspectRatio(width / height);
                    const container = this.cropper.getContainerData();
                    const w = Math.min(container.width * .88, container.height * .88 * width / height);
                    const h = w * height / width;
                    this.cropper.setCropBoxData({ left: (container.width - w) / 2, top: (container.height - h) / 2, width: w, height: h });
                    dialog.querySelector('[data-crop-info]').textContent = `${file.name} · Image ${index + 1} of ${total} · Original: ${original.naturalWidth} × ${original.naturalHeight} px`;
                    dialog.querySelector('[data-crop-size]').textContent = `Output: ${width} × ${height} px`;
                    setTimeout(() => {
                        if (finished) return;
                        ready = true;
                        fit();
                        applyButton.disabled = false;
                        render();
                    }, 0);
                },
                crop: render,
            });
            dialog.oncancel = event => { event.preventDefault(); finish(null); };
            dialog.onclick = async event => {
                if (event.target.closest('[data-crop-cancel]')) return finish(null);
                if (!ready) return;
                const zoom = event.target.closest('[data-crop-zoom]');
                if (zoom) cropper.zoom(Number(zoom.dataset.cropZoom));
                if (event.target.closest('[data-crop-fit]')) fit();
                if (event.target.closest('[data-crop-reset]')) { cropper.reset(); fit(); }
                if (!event.target.closest('[data-crop-apply]')) return;
                applyButton.disabled = true;
                try {
                    const canvas = cropper.getCroppedCanvas({ width, height, fillColor: '#fff', imageSmoothingEnabled: true, imageSmoothingQuality: 'high' });
                    const blob = await new Promise(done => canvas.toBlob(done, 'image/jpeg', .92));
                    if (finished) return;
                    if (!blob) throw new Error('Could not export image.');
                    if (blob.size > options.maximumBytes) throw new Error('The adjusted image is too large. Cancel and select a smaller image.');
                    finish(new File([blob], file.name.replace(/\.[^.]+$/, '') + '.jpg', { type: 'image/jpeg', lastModified: Date.now() }));
                } catch (exception) {
                    error.textContent = exception.message;
                    applyButton.disabled = false;
                }
            };
        });
    }

    document.addEventListener('change', async event => {
        const input = event.target;
        if (!(input instanceof HTMLInputElement) || input.type !== 'file' || !/image\//.test(input.accept) || input.dataset.mediaKind === 'video') return;
        if (approved.has(input)) { approved.delete(input); return; }
        const files = Array.from(input.files || []);
        if (!files.length) return;
        event.stopImmediatePropagation();
        if (busy) { input.value = ''; return; }
        busy = true;
        const form = input.form;
        if (form) form.dataset.cropPending = 'true';
        const output = [];
        try {
            for (let index = 0; index < files.length; index++) {
                const file = files[index];
                if (!/^image\/(jpeg|png|webp|gif)$/.test(file.type)) { output.push(file); continue; }
                const result = await edit(file, {
                    width: input.dataset.cropWidth,
                    height: input.dataset.cropHeight,
                    maximumBytes: Number(input.dataset.maxBytes) || 5 * 1024 * 1024,
                }, index, files.length);
                if (!result) { input.value = ''; return; }
                output.push(result);
            }
            const transfer = new DataTransfer();
            output.forEach(file => transfer.items.add(file));
            input.files = transfer.files;
            approved.add(input);
            input.dispatchEvent(new Event('change', { bubbles: true }));
            if (form) {
                let summary = input.parentElement.querySelector('[data-crop-summary]');
                if (!summary) { summary = document.createElement('p'); summary.dataset.cropSummary = ''; input.after(summary); }
                summary.textContent = `${output.length} image(s) ready. Save the form to upload.`;
            }
        } catch (exception) {
            input.value = '';
            if (dialog.open) dialog.close();
            window.alert('The image editor could not process this selection. Please select another image.');
        } finally {
            busy = false;
            if (form) delete form.dataset.cropPending;
        }
    }, true);
    document.addEventListener('submit', event => {
        if (event.target.dataset.cropPending) { event.preventDefault(); event.stopImmediatePropagation(); }
    }, true);
})();
