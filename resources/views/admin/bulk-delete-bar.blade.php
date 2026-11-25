@if ($errors->has('ids') || $errors->has('ids.*'))
    <p role="alert" class="mb-4 rounded bg-red-100 p-3 text-red-900">{{ $errors->first('ids') ?: $errors->first('ids.*') }}</p>
@endif
@if ($items->isNotEmpty())
    <form id="{{ $formId }}" method="post" action="{{ $action }}" class="admin-bulk-bar" data-bulk-delete-form data-bulk-singular="{{ $singular }}" data-bulk-plural="{{ $plural }}">
        @csrf
        @method('DELETE')
        <span class="admin-bulk-bar__count" data-bulk-count>0 selected</span>
        <button type="submit" class="admin-bulk-bar__delete" data-bulk-delete-button disabled>
            <svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Delete selected</span>
        </button>
    </form>
@endif
<script src="{{ asset('js/company-bulk-delete.js') }}?v={{ filemtime(public_path('js/company-bulk-delete.js')) }}" defer></script>
