(() => {
    'use strict';
    document.querySelectorAll('[data-client-reviews]').forEach(group => {
        const tabs = Array.from(group.querySelectorAll('[role="tab"]'));
        const nav = group.querySelector('[role="tablist"]');
        const media = window.matchMedia('(min-width: 768px)');
        const orient = () => nav.setAttribute('aria-orientation', media.matches ? 'vertical' : 'horizontal');
        orient();
        media.addEventListener('change', orient);
        function activate(tab, focus = false) {
            tabs.forEach(item => {
                const selected = item === tab;
                item.setAttribute('aria-selected', String(selected));
                item.tabIndex = selected ? 0 : -1;
                item.classList.toggle('active', selected);
                document.getElementById(item.getAttribute('aria-controls')).hidden = !selected;
            });
            if (focus) tab.focus();
        }
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => activate(tab));
            tab.addEventListener('keydown', event => {
                const previous = media.matches ? 'ArrowUp' : 'ArrowLeft';
                const next = media.matches ? 'ArrowDown' : 'ArrowRight';
                let target;
                if (event.key === previous) target = (index - 1 + tabs.length) % tabs.length;
                else if (event.key === next) target = (index + 1) % tabs.length;
                else if (event.key === 'Home') target = 0;
                else if (event.key === 'End') target = tabs.length - 1;
                else return;
                event.preventDefault();
                activate(tabs[target], true);
            });
        });
    });
})();
