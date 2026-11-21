(() => {
    'use strict';
    const approved = new WeakSet();
    const widgets = new WeakMap();
    const previousSelections = new WeakMap();
    let busy = false;
    document.querySelectorAll('input[type="file"]').forEach(input => {
        if (input.multiple || !/image\//.test(input.accept) || input.dataset.mediaKind === 'video') return;
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'image-upload-tile';
        button.setAttribute('aria-label', 'Add image');
        button.innerHTML = '<img alt="Selected image"><span class="image-upload-tile__overlay"><span class="image-upload-tile__plus" aria-hidden="true">+</span><span>Add image</span></span>';
        input.classList.add('image-upload-native');
        input.after(button);
        const widget = { button, image: button.querySelector('img'), url: null };
        widgets.set(input, widget);
        if (input.dataset.currentImage) {
            widget.image.src = input.dataset.currentImage;
            button.classList.add('has-image');
        }
        button.addEventListener('click', () => input.click());
    });
    const dialog = document.createElement('dialog');
    dialog.className = 'image-crop-editor';
    dialog.setAttribute('data-cms-ignore', '');
    dialog.setAttribute('aria-labelledby', 'crop-heading');
    const icon = paths => `<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${paths}</svg>`;
    dialog.innerHTML = `<div class="image-crop-editor__heading"><h2 id="crop-heading">Adjust image</h2><button type="button" data-crop-cancel aria-label="Cancel image selection" title="Close editor">${icon('<path d="m6 6 12 12M18 6 6 18"/>')}</button></div>
        <div class="image-crop-editor__workspace">
            <div class="image-crop-editor__stage"><img alt="Image being adjusted" data-crop-image></div>
            <div class="image-crop-editor__resize-handles">${['nw', 'ne', 'sw', 'se'].map(corner => `<button type="button" data-crop-resize="${corner}" aria-label="Resize image from ${corner}. Use arrow keys to adjust." title="Drag to resize image"></button>`).join('')}</div>
            <div class="image-crop-editor__utility-tools" role="group" aria-label="Image tools">
                <button type="button" data-crop-fit aria-label="Fit whole image" title="Fit whole image">${icon('<path d="M8 3H3v5m13-5h5v5M3 16v5h5m13-5v5h-5"/><rect x="7" y="7" width="10" height="10" rx="1"/>')}</button>
                <button type="button" data-crop-reset aria-label="Reset image" title="Reset image">${icon('<path d="M3 11a9 9 0 1 1 2.7 7M3 4v7h7"/>')}</button>
            </div>
            <div class="image-crop-editor__zoom-tools" role="group" aria-label="Zoom controls">
                <button type="button" data-crop-zoom="0.15" aria-label="Zoom in" title="Zoom in">${icon('<circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5M7.5 10.5h6m-3-3v6"/>')}</button>
                <output data-crop-percent aria-live="polite" aria-label="Image zoom" title="Zoom relative to original image size">100%</output>
                <button type="button" data-crop-zoom="-0.15" aria-label="Zoom out" title="Zoom out">${icon('<circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5M7.5 10.5h6"/>')}</button>
            </div>
        </div>
        <p class="image-crop-editor__size" data-crop-size></p>
        <p role="alert" data-crop-error></p><div class="image-crop-editor__actions"><button type="button" data-crop-cancel>Cancel selection</button><button type="button" data-crop-apply>Use this image</button></div>`;
    document.body.append(dialog);
    const image = dialog.querySelector('[data-crop-image]');
    const zoomPercent = dialog.querySelector('[data-crop-percent]');
    const applyButton = dialog.querySelector('[data-crop-apply]');

    function edit(file, options) {
        return new Promise(resolve => {
            let cropper;
            let width;
            let height;
            let ready = false;
            let finished = false;
            let resizing = null;
            const source = URL.createObjectURL(file);
            const error = dialog.querySelector('[data-crop-error]');
            error.textContent = '';
            applyButton.disabled = true;
            function render() {
                if (!ready) return;
                const data = cropper.getImageData();
                zoomPercent.textContent = `${Math.round(data.width / data.naturalWidth * 100)}%`;
                const canvas = cropper.getCanvasData();
                const container = cropper.getContainerData();
                dialog.querySelectorAll('[data-crop-resize]').forEach(handle => {
                    const corner = handle.dataset.cropResize;
                    const x = canvas.left + (corner.includes('e') ? canvas.width : 0);
                    const y = canvas.top + (corner.includes('s') ? canvas.height : 0);
                    handle.style.left = `${Math.max(12, Math.min(container.width - 12, x))}px`;
                    handle.style.top = `${Math.max(12, Math.min(container.height - 12, y))}px`;
                });
            }
            function finish(result) {
                if (finished) return;
                finished = true;
                ready = false;
                cropper?.destroy();
                URL.revokeObjectURL(source);
                dialog.close();
                dialog.oncancel = null;
                dialog.onclick = null;
                dialog.onpointerdown = null;
                dialog.onpointermove = null;
                dialog.onpointerup = null;
                dialog.onpointercancel = null;
                dialog.onkeydown = null;
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
            dialog.onpointerdown = event => {
                const handle = event.target.closest('[data-crop-resize]');
                if (!ready || !handle || event.button !== 0) return;
                event.preventDefault();
                event.stopPropagation();
                const canvas = cropper.getCanvasData();
                const east = handle.dataset.cropResize.includes('e');
                const south = handle.dataset.cropResize.includes('s');
                resizing = {
                    pointerId: event.pointerId, x: event.clientX, y: event.clientY, canvas, east, south,
                    anchorX: canvas.left + (east ? 0 : canvas.width),
                    anchorY: canvas.top + (south ? 0 : canvas.height),
                };
                handle.setPointerCapture(event.pointerId);
            };
            dialog.onpointermove = event => {
                if (!resizing || event.pointerId !== resizing.pointerId) return;
                event.preventDefault();
                const { x, y, canvas, east, south, anchorX, anchorY } = resizing;
                const vx = (east ? 1 : -1) * canvas.width;
                const vy = (south ? 1 : -1) * canvas.height;
                const scale = Math.max(.02, Math.min(20, 1 + ((event.clientX - x) * vx + (event.clientY - y) * vy) / (vx * vx + vy * vy)));
                cropper.setCanvasData({ width: canvas.width * scale });
                cropper.moveTo(east ? anchorX : anchorX - canvas.width * scale, south ? anchorY : anchorY - canvas.height * scale);
                render();
            };
            dialog.onpointerup = dialog.onpointercancel = () => { resizing = null; };
            dialog.onkeydown = event => {
                if (!ready || !event.target.closest('[data-crop-resize]') || !['ArrowUp', 'ArrowRight', 'ArrowDown', 'ArrowLeft'].includes(event.key)) return;
                event.preventDefault();
                cropper.zoom(['ArrowUp', 'ArrowRight'].includes(event.key) ? .05 : -.05);
            };
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
                });
                if (!result) {
                    const restored = new DataTransfer();
                    (previousSelections.get(input) || []).forEach(file => restored.items.add(file));
                    input.files = restored.files;
                    return;
                }
                output.push(result);
            }
            const transfer = new DataTransfer();
            output.forEach(file => transfer.items.add(file));
            input.files = transfer.files;
            previousSelections.set(input, output);
            const widget = widgets.get(input);
            if (widget && output[0]) {
                if (widget.url) URL.revokeObjectURL(widget.url);
                widget.url = URL.createObjectURL(output[0]);
                widget.image.src = widget.url;
                widget.button.classList.add('has-image');
                if (input.name === 'image_upload') {
                    const remove = form?.querySelector('[name="remove_image"]');
                    if (remove) remove.checked = false;
                }
                const removeAsset = input.name === 'upload' && form?.querySelector('[name="remove"]');
                if (removeAsset) removeAsset.checked = false;
            }
            approved.add(input);
            input.dispatchEvent(new Event('change', { bubbles: true }));
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
