(() => {
    'use strict';

    const stack = document.querySelector('[data-cms-variant="home-services"]');
    if (!stack) return;

    const desktop = window.matchMedia('(min-width: 64rem)');
    const observedCards = new Set();
    const cardResizeObserver = new ResizeObserver(scheduleRebuild);
    let stages = [];
    let releaseAt = 0;
    let rebuildFrame = 0;
    let scrollFrame = 0;

    function cardsInStack() {
        return Array.from(stack.children).filter(child => child.classList.contains('home-service-stack__card'));
    }

    function scheduleRebuild() {
        if (rebuildFrame) return;
        rebuildFrame = requestAnimationFrame(rebuild);
    }

    function scheduleScrollUpdate() {
        if (scrollFrame) return;
        scrollFrame = requestAnimationFrame(updatePositions);
    }

    function updatePositions() {
        scrollFrame = 0;
        const scrollY = window.scrollY;

        stages.forEach(stage => {
            const shift = Math.max(0, Math.min(scrollY - stage.start, releaseAt - stage.start));
            if (shift === stage.shift) return;
            stage.card.style.setProperty('--home-service-shift', `${shift}px`);
            stage.shift = shift;
        });
    }

    function rebuild() {
        rebuildFrame = 0;
        const cards = cardsInStack();

        observedCards.forEach(card => {
            if (cards.includes(card)) return;
            cardResizeObserver.unobserve(card);
            observedCards.delete(card);
        });
        cards.forEach(card => {
            if (observedCards.has(card)) return;
            cardResizeObserver.observe(card);
            observedCards.add(card);
        });

        if (!desktop.matches || cards.length < 2) {
            stack.classList.remove('is-stacked');
            stack.style.removeProperty('height');
            stages = [];
            return;
        }

        const heights = cards.map(card => card.offsetHeight + (Number.parseFloat(getComputedStyle(card).marginBottom) || 0));
        const maxCardHeight = Math.max(...cards.map(card => card.offsetHeight));
        const navigationBottom = Math.max(0, document.querySelector('.nav-sticky')?.getBoundingClientRect().bottom || 0);
        const firstTop = Math.max(16, Math.min(Math.max(100, navigationBottom + 12), window.innerHeight - maxCardHeight - 16));
        const visibleHeaderHeight = Math.max(...cards.map(card => {
            const cardTop = card.getBoundingClientRect().top;
            const heading = card.querySelector('.home-service-card__heading');
            const icon = card.querySelector('.home-service-card__icon');

            return Math.max(
                heading ? heading.getBoundingClientRect().bottom - cardTop : 0,
                icon ? icon.getBoundingClientRect().bottom - cardTop : 0,
            );
        })) + 14;
        const availableStep = (window.innerHeight - firstTop - maxCardHeight - 16) / (cards.length - 1);

        if (availableStep < visibleHeaderHeight) {
            stack.classList.remove('is-stacked');
            stack.style.removeProperty('height');
            stages = [];
            return;
        }

        const step = Math.min(availableStep, 160);
        const stackTop = stack.getBoundingClientRect().top + window.scrollY;
        const holdDistance = Math.min(180, Math.max(80, window.innerHeight / 4));
        let flowTop = 0;

        stages = cards.map((card, index) => {
            const targetTop = firstTop + index * step;
            const stage = {
                card,
                start: stackTop + flowTop - targetTop,
                shift: null,
            };
            card.style.setProperty('--home-service-flow-top', `${flowTop}px`);
            card.style.setProperty('--home-service-layer', `${index + 1}`);
            flowTop += heights[index];
            return stage;
        });

        releaseAt = stages[stages.length - 1].start + holdDistance;
        stack.style.height = `${flowTop + holdDistance}px`;
        stack.classList.add('is-stacked');
        updatePositions();
    }

    new MutationObserver(mutations => {
        if (mutations.some(mutation => mutation.target === stack)) scheduleRebuild();
    }).observe(stack, { childList: true });

    window.addEventListener('scroll', scheduleScrollUpdate, { passive: true });
    window.addEventListener('resize', scheduleRebuild);
    window.addEventListener('load', scheduleRebuild, { once: true });
    desktop.addEventListener('change', scheduleRebuild);
    document.fonts?.ready.then(scheduleRebuild);
    scheduleRebuild();
})();
