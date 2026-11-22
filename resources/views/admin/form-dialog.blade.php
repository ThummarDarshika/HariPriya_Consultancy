<dialog class="company-dialog content-dialog" aria-labelledby="content-dialog-title" data-form-dialog>
    <header class="company-dialog__header">
        <h2 id="content-dialog-title">Add item</h2>
        <button type="button" class="company-dialog__close" data-form-dialog-close aria-label="Close form"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
    </header>
    <div class="content-dialog__body" data-form-dialog-body></div>
    <footer class="company-dialog__footer">
        <button type="button" class="company-dialog__cancel" data-form-dialog-close>Cancel</button>
        <button type="submit" form="content-dialog-form" class="company-dialog__save" data-form-dialog-save disabled>Save changes</button>
    </footer>
</dialog>
<script src="{{ asset('js/form-dialog.js') }}?v={{ filemtime(public_path('js/form-dialog.js')) }}" defer></script>
