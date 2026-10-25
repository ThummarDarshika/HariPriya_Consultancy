(() => {
    'use strict';

    const galleries = document.querySelectorAll('[data-product-gallery]');
    if (!galleries.length) return;

    let dialog;
    let image;
    let caption;

    function createDialog() {
        dialog = document.createElement('dialog');
        dialog.className = 'product-gallery-dialog';
        dialog.innerHTML = '<button type="button" class="product-gallery-dialog__close" aria-label="Close image">&times;</button><img class="product-gallery-dialog__image" alt=""><p class="product-gallery-dialog__caption"></p>';
        image = dialog.querySelector('img');
        caption = dialog.querySelector('p');

        dialog.querySelector('button').addEventListener('click', () => dialog.close());
        dialog.addEventListener('click', event => {
            if (event.target === dialog) dialog.close();
        });

        document.body.append(dialog);
    }

    galleries.forEach(gallery => {
        gallery.addEventListener('click', event => {
            const link = event.target.closest('a');
            if (!link || !gallery.contains(link)) return;

            event.preventDefault();
            if (document.querySelector('meta[name="cms-save-url"]')) return;

            const productImage = link.querySelector('img');
            if (!productImage?.currentSrc) return;

            if (!dialog) createDialog();
            const title = link.closest('[data-cms-collection] > div')?.querySelector('h3')?.textContent?.trim() || productImage.alt;
            image.src = productImage.currentSrc;
            image.alt = title || '';
            caption.textContent = title || '';
            dialog.showModal();
        });
    });
})();
