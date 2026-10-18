<div id="cms-editor-toolbar" class="cms-editor-toolbar" data-cms-ignore>
    <label for="cms-page-switcher">Page</label>
    <select id="cms-page-switcher" aria-label="Choose a page">
        @foreach (\App\Http\Controllers\Admin\VisualEditorController::PAGES as $page)
            <option value="{{ route('admin.editor', ['page' => $page]) }}" @selected($cmsEditorPage === $page)>{{ ucwords(str_replace('-', ' ', $page)) }}</option>
        @endforeach
    </select>
    <span id="cms-draft-count" aria-live="polite">0 unsaved</span>
    <span>Alt+click a header/footer link to edit its URL</span>
    <button type="button" id="cms-discard">Discard Edits</button>
    <button type="button" id="cms-save">Save &amp; Publish</button>
    <a href="{{ route('admin.dashboard') }}">Back to Admin Dashboard</a>
    <span id="cms-status" role="status"></span>
</div>
