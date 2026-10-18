(() => {
    'use strict';

    const baseUrl = document.querySelector('meta[name="cms-collections-url"]')?.content;
    const groups = Array.from(document.querySelectorAll('[data-cms-collection]'));
    if (!baseUrl || !groups.length) return;

    function setText(card, selector, value) {
        const element = card.querySelector(selector);
        if (element) element.textContent = value || '';
    }

    function setRichText(card, selector, html) {
        const element = card.querySelector(selector);
        if (element) element.innerHTML = html || '';
    }

    function setImage(card, selector, value) {
        const image = card.querySelector(selector);
        if (image && value) image.src = value;
    }

    function updateCard(card, collection, item) {
        if (collection === 'services') {
            setText(card, 'h2', item.title);
            setRichText(card, 'p', item.description_blocks_html?.[0]);
            setImage(card, 'img', item.image);
        } else if (collection === 'products') {
            setText(card, 'h3', item.title);
            setRichText(card, 'p', item.description_blocks_html?.[0]);
            setImage(card, 'img', item.image);
            const metadata = card.querySelectorAll('.divide-y > div > div:last-child');
            if (metadata[0]) metadata[0].textContent = item.material || '';
            if (metadata[1]) metadata[1].textContent = item.capability || '';
            if (metadata[2]) metadata[2].textContent = item.size_range || '';
        } else if (collection === 'blogs') {
            setText(card, 'h2', item.title);
            setText(card, '.bg-white.text-primary', item.category);
            setText(card, 'p.text-sm', item.display_date);
            setImage(card, 'img', item.image);
            const link = card.querySelector('a[href*="blog-detail"]');
            if (link) {
                const url = new URL(link.href);
                url.searchParams.set('slug', item.slug);
                link.href = url.toString();
            }
        } else if (collection === 'case-studies') {
            setText(card, 'h2', item.title);
            setText(card, 'span.bg-white', item.category);
            setText(card, 'h3', item.metric);
            setRichText(card, 'p', item.description_blocks_html?.[0]);
            setImage(card, 'img', item.image);
            setImage(card, 'img.h-7\\.5', item.icon);
        } else if (collection === 'faqs') {
            setText(card, 'h3', item.title);
            setRichText(card, '.hs-accordion-content p', item.description_blocks_html?.[0]);
        } else if (collection === 'team-members') {
            setText(card, 'h3', item.title);
            setText(card, '.team-job-title', item.role);
            setImage(card, 'img', item.image);
            const socialLinks = card.querySelectorAll('.social-link');
            if (socialLinks[0] && (item.social_links?.instagram || item.social_links?.primary)) socialLinks[0].href = item.social_links.instagram || item.social_links.primary;
            if (socialLinks[1] && item.social_links?.linkedin) socialLinks[1].href = item.social_links.linkedin;
            if (socialLinks[2] && item.social_links?.x) socialLinks[2].href = item.social_links.x;
        } else if (collection === 'testimonials') {
            setText(card, 'h3', item.client_name || item.title);
            setRichText(card, 'p', item.description_blocks_html?.[0]);
            setImage(card, 'img', item.image);
        }
    }

    function renderTestimonials(group, items) {
        if (!items.length) return;
        const buttons = Array.from(group.querySelectorAll('[role="tab"]'));
        const panels = Array.from(group.querySelectorAll('[role="tabpanel"]'));
        panels.forEach((panel, index) => {
            const item = items[index];
            if (!item) {
                if (buttons[index]) buttons[index].style.display = 'none';
                panel.style.display = 'none';
                return;
            }
            setRichText(panel, 'p', item.description_blocks_html?.[0]);
            setText(panel, 'h3', item.client_name || item.title);
            setText(panel, '.text-sm.text-default-600', item.designation);
            if (buttons[index]) setImage(buttons[index], 'img', item.image);
            const stars = panel.querySelectorAll('.tabler--star-filled');
            stars.forEach((star, starIndex) => { star.hidden = starIndex >= (item.rating || 5); });
        });
    }

    function renderHomeServices(group, items) {
        if (!items.length) return;
        const originalCards = Array.from(group.children).filter(child => !child.classList.contains('cms-collection-badge'));
        const template = originalCards[0]?.cloneNode(true);
        if (!template) return;
        items.forEach((item, index) => {
            const card = originalCards[index] || template.cloneNode(true);
            if (!originalCards[index]) group.append(card);
            setText(card, 'h2', item.title);
            setImage(card, 'img.rounded', item.image);
            setImage(card, 'img.size-10', item.icon);
            const featureHost = card.querySelector('.space-y-2\\.5');
            const featureRows = Array.from(featureHost?.children || []);
            const featureTemplate = featureRows[0]?.cloneNode(true);
            (item.features || []).forEach((feature, featureIndex) => {
                const row = featureRows[featureIndex] || featureTemplate?.cloneNode(true);
                if (!row) return;
                if (!featureRows[featureIndex]) featureHost.append(row);
                const label = row.querySelector('div:last-child');
                if (label) label.textContent = feature;
            });
            featureRows.slice((item.features || []).length).forEach(row => row.remove());
        });
        originalCards.slice(items.length).forEach(card => card.remove());
    }

    function renderHomeCases(group, items) {
        if (!items.length) return;
        const slides = Array.from(group.querySelectorAll(':scope > .swiper-slide'));
        slides.forEach((slide, index) => {
            const item = items[index];
            if (!item) { slide.remove(); return; }
            const headings = slide.querySelectorAll('h3');
            if (headings[0]) headings[0].textContent = item.title;
            if (headings[1]) headings[1].textContent = item.metric || '';
            setRichText(slide, 'p', item.description_blocks_html?.[0]);
            setImage(slide, 'img.rounded-md', item.image);
            const images = slide.querySelectorAll('img');
            if (images[1] && item.icon) images[1].src = item.icon;
        });
    }

    function renderBlogDetail(group, items) {
        const slug = new URLSearchParams(location.search).get('slug');
        const item = (slug && items.find(candidate => candidate.slug === slug)) || items[0];
        if (!item) return;

        if (group.dataset.cmsVariant === 'detail-hero') {
            setText(group, 'h1', item.title);
            const badges = group.querySelectorAll('.text-center > span');
            if (badges[0]) badges[0].textContent = item.display_date || '';
            if (badges[1]) badges[1].textContent = item.category || '';
            setRichText(group, 'p', item.summary_html || item.description_blocks_html?.[0]);
            setImage(group, 'img', item.image);
        } else {
            const content = group.querySelector('.container');
            if (!content) return;
            const headings = content.querySelectorAll('h2');
            if (headings[0]) headings[0].textContent = item.title;
            if (headings[1]) {
                headings[1].textContent = item.article_subheading || '';
                headings[1].hidden = !item.article_subheading;
            }
            const blocks = item.description_blocks_html || [];
            const elements = Array.from(content.querySelectorAll('p, li, blockquote em'));
            elements.forEach((element, index) => {
                element.innerHTML = blocks[index] || '';
                element.hidden = !blocks[index];
            });
            blocks.slice(elements.length).forEach(block => {
                const paragraph = document.createElement('p');
                paragraph.className = 'mt-5';
                paragraph.innerHTML = block;
                content.append(paragraph);
            });
            const iframe = content.querySelector('iframe');
            if (iframe) {
                iframe.parentElement.hidden = !item.video_url;
                if (item.video_url) iframe.src = item.video_url;
            }
        }
    }

    function render(group, collection, items) {
        if (!items.length) {
            group.style.display = 'none';
            return;
        }
        if (group.dataset.cmsLimit) items = items.slice(0, Number(group.dataset.cmsLimit));
        if (group.dataset.cmsVariant === 'tabs') return renderTestimonials(group, items);
        if (group.dataset.cmsVariant === 'home-services') return renderHomeServices(group, items);
        if (group.dataset.cmsVariant === 'home-cases') return renderHomeCases(group, items);
        if (group.dataset.cmsVariant === 'detail-hero' || group.dataset.cmsVariant === 'detail-body') return renderBlogDetail(group, items);
        if (group.hasAttribute('data-cms-index')) {
            const item = items[Number(group.dataset.cmsIndex)];
            if (item) {
                setText(group, 'h3', item.title);
                setImage(group, 'img', item.image);
                const link = group.querySelector('a');
                if (link) {
                    const url = new URL(document.querySelector('meta[name="cms-blog-detail-url"]').content, location.origin);
                    url.searchParams.set('slug', item.slug);
                    link.href = url.toString();
                }
            } else group.remove();
            return;
        }
        const originalCards = Array.from(group.children).filter(child => !child.classList.contains('cms-collection-badge'));
        if (!originalCards.length) return;
        const template = (collection === 'blogs' || collection === 'faqs') && originalCards[1] ? originalCards[1].cloneNode(true) : originalCards[0].cloneNode(true);

        items.forEach((item, index) => {
            const card = originalCards[index] || template.cloneNode(true);
            if (!originalCards[index]) group.append(card);
            updateCard(card, collection, item);
        });

        originalCards.slice(items.length).forEach(card => card.remove());
    }

    function fetchCollection(collection) {
        return fetch(`${baseUrl}/${encodeURIComponent(collection)}`, { headers: { Accept: 'application/json' } })
            .then(response => {
                if (!response.ok) throw new Error('Collection unavailable');
                return response.json();
            });
    }

    for (const collection of new Set(groups.map(group => group.dataset.cmsCollection))) {
        const requests = [fetchCollection(collection)];
        Promise.all(requests)
            .then(results => {
                const items = results.flat();
                groups.filter(group => group.dataset.cmsCollection === collection)
                    .forEach(group => render(group, collection, items));
            })
            .catch(() => {});
    }
})();
