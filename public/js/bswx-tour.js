(() => {
    const section = document.getElementById('bswx-tour');
    const frame = document.getElementById('bswx-tour-frame');

    if (!section || !frame) {
        return;
    }

    const navigation = document.querySelector('.nav-sticky');
    const heroSection = document.getElementById('bswx-hero');
    const heroSlot = document.getElementById('bswx-hero-model');
    const openButton = document.getElementById('bswx-tour-open');
    const exitButton = document.getElementById('bswx-tour-exit');
    const toolbar = document.getElementById('bswx-tour-toolbar');
    const siteLoader = document.getElementById('bswx-site-loader');
    if (document.documentElement.classList.contains('bswx-return-visit') && siteLoader) siteLoader.hidden = true;
    const loaderLogo = document.getElementById('bswx-site-loader-logo');
    const headerLogo = Array.from(document.querySelectorAll('[data-bswx-header-logo]'))
        .find((logo) => !logo.classList.contains('hidden'));
    const loaderMessage = document.getElementById('bswx-site-loader-message');
    const retryButton = document.getElementById('bswx-site-loader-retry');
    if (loaderLogo && !loaderLogo.getAttribute('src') && headerLogo) {
        loaderLogo.src = headerLogo.src;
    }
    let mode = 'preview';
    let placeholder = null;

    const revealSite = () => {
        if (!siteLoader || siteLoader.hidden || siteLoader.classList.contains('is-leaving')) return;

        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const start = loaderLogo?.getBoundingClientRect();
        const end = headerLogo?.getBoundingClientRect();
        if (!reducedMotion && loaderLogo?.complete && loaderLogo.naturalWidth && start?.width && end?.width) {
            const flyingLogo = loaderLogo.cloneNode(true);
            flyingLogo.removeAttribute('id');
            flyingLogo.className = 'bswx-site-loader__flying-logo';
            Object.assign(flyingLogo.style, {
                left: `${start.left}px`,
                top: `${start.top}px`,
                width: `${start.width}px`,
                height: `${start.height}px`,
            });
            document.body.appendChild(flyingLogo);
            loaderLogo.style.visibility = 'hidden';
            headerLogo.style.visibility = 'hidden';
            const movement = flyingLogo.animate([
                { transform: 'translate(0, 0) scale(1, 1)' },
                { transform: `translate(${end.left - start.left}px, ${end.top - start.top}px) scale(${end.width / start.width}, ${end.height / start.height})` },
            ], { duration: 900, easing: 'cubic-bezier(.22, 1, .36, 1)', fill: 'forwards' });
            movement.finished.catch(() => {}).finally(() => {
                headerLogo.style.visibility = '';
                flyingLogo.remove();
                siteLoader.hidden = true;
            });
        } else {
            window.setTimeout(() => { siteLoader.hidden = true; }, 900);
        }
        siteLoader.classList.add('is-leaving');
    };

    const showLoadError = () => {
        if (!siteLoader) return;

        document.documentElement.classList.remove('bswx-return-visit');
        siteLoader.hidden = false;
        try { sessionStorage.removeItem('bswx-ready-version'); } catch (error) {}
        loaderMessage.textContent = 'The 3D model could not load. Please try again.';
        retryButton.hidden = false;
    };

    retryButton?.addEventListener('click', () => window.location.reload());

    const sendToViewer = (type, data = {}) => {
        frame.contentWindow?.postMessage({ type, ...data }, window.location.origin);
    };

    const releaseFrame = () => {
        frame.classList.remove('is-hero');
        for (const property of ['left', 'top', 'width', 'height']) frame.style.removeProperty(property);
    };

    const syncFramePlacement = () => {
        if (!heroSlot || mode !== 'preview') return;

        const heroRect = heroSlot.getBoundingClientRect();
        frame.classList.add('is-hero');
        frame.style.left = `${heroRect.left}px`;
        frame.style.top = `${heroRect.top}px`;
        frame.style.width = `${heroRect.width}px`;
        frame.style.height = `${heroRect.height}px`;
    };

    const updateDimensions = () => {
        const headerHeight = navigation?.getBoundingClientRect().height ?? 0;
        heroSection.style.setProperty('--bswx-header-height', `${headerHeight}px`);
        syncFramePlacement();
    };

    const showExpanded = () => {
        releaseFrame();
        placeholder = document.createElement('div');
        placeholder.style.height = `${section.offsetHeight}px`;
        section.before(placeholder);
        section.classList.add('is-expanded');
        document.body.classList.add('bswx-tour-locked');
        toolbar.hidden = false;
        mode = 'interactive';
        sendToViewer('bswx-interactive', { enabled: true });
        frame.focus();
    };

    const closeExpanded = () => {
        if (mode !== 'interactive') return;

        mode = 'preview';
        sendToViewer('bswx-interactive', { enabled: false });
        toolbar.hidden = true;
        section.classList.remove('is-expanded');
        document.body.classList.remove('bswx-tour-locked');
        placeholder?.remove();
        placeholder = null;
        updateDimensions();
    };

    openButton.addEventListener('click', showExpanded);
    exitButton.addEventListener('click', closeExpanded);

    frame.addEventListener('load', () => {
        sendToViewer('bswx-interactive', { enabled: mode === 'interactive' });
        sendToViewer('bswx-status-request');
    });

    window.addEventListener('message', (event) => {
        if (event.source !== frame.contentWindow || event.origin !== window.location.origin) return;

        if (event.data?.type === 'bswx-ready') {
            try { sessionStorage.setItem('bswx-ready-version', siteLoader?.dataset.modelVersion || ''); } catch (error) {}
            revealSite();
        } else if (event.data?.type === 'bswx-error') {
            showLoadError();
        } else if (event.data?.type === 'bswx-exit') {
            closeExpanded();
        }
    });

    window.addEventListener('scroll', () => {
        syncFramePlacement();
    }, { passive: true });

    window.addEventListener('resize', updateDimensions);
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeExpanded();
        } else if (mode === 'interactive' && ['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(event.key)) {
            event.preventDefault();
            sendToViewer('bswx-arrow', { key: event.key });
        }
    });

    updateDimensions();
    sendToViewer('bswx-status-request');
})();
