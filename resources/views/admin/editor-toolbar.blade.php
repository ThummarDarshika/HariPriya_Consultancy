<div id="cms-editor-toolbar" class="cms-editor-toolbar" data-cms-ignore>
    <button type="button" id="cms-discard" aria-label="Discard edits" title="Discard edits">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 7H5V3M5.5 7.5A8 8 0 1 1 4 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
    </button>
    <div class="cms-editor-page-picker">
        <svg class="cms-editor-page-picker__icon" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 1 5 17.5v-13Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M5 17.5A2.5 2.5 0 0 1 7.5 15H20" stroke="currentColor" stroke-width="1.8"/></svg>
        <select id="cms-page-switcher" aria-label="Choose a page" title="Choose a page">
            @foreach (\App\Http\Controllers\Admin\VisualEditorController::PAGES as $page)
                <option value="{{ route('admin.editor', ['page' => $page]) }}" @selected($cmsEditorPage === $page)>{{ ucwords(str_replace('-', ' ', $page)) }}</option>
            @endforeach
        </select>
        <svg class="cms-editor-page-picker__chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m7 9 5 5 5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </div>
    <span id="cms-status" role="status"></span>
    <button type="button" id="cms-save" aria-label="Save and publish" title="Save and publish">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 16V4m0 0 4.5 4.5M12 4 7.5 8.5M5 14v5h14v-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span>(<span id="cms-draft-count" aria-live="polite">0</span>)</span>
    </button>
</div>
