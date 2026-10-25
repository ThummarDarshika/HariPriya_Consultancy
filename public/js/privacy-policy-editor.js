(() => {
    'use strict';

    const form = document.querySelector('[data-privacy-policy-form]');
    const editor = document.querySelector('[data-privacy-policy-content]');
    const field = document.querySelector('[data-privacy-policy-field]');
    const error = document.querySelector('[data-privacy-policy-error]');
    if (!form || !editor || !field || !error) return;

    const syncContent = () => {
        field.value = editor.innerHTML;
        error.hidden = Boolean(editor.textContent.trim());
    };

    form.querySelectorAll('[data-editor-command], [data-editor-size]').forEach(button => {
        button.addEventListener('mousedown', event => event.preventDefault());
        button.addEventListener('click', () => {
            editor.focus();
            if (button.dataset.editorSize) {
                const currentSize = Number(document.queryCommandValue('fontSize')) || 3;
                const nextSize = Math.max(1, Math.min(7, currentSize + (button.dataset.editorSize === 'increase' ? 1 : -1)));
                document.execCommand('fontSize', false, String(nextSize));
            } else {
                document.execCommand(button.dataset.editorCommand, false, button.dataset.editorValue || null);
            }
            syncContent();
        });
    });

    editor.addEventListener('input', syncContent);
    editor.addEventListener('paste', event => {
        event.preventDefault();
        document.execCommand('insertText', false, event.clipboardData.getData('text/plain'));
    });

    form.addEventListener('submit', event => {
        syncContent();
        if (!editor.textContent.trim()) {
            event.preventDefault();
            error.hidden = false;
            editor.focus();
        }
    }, true);

    syncContent();
})();
