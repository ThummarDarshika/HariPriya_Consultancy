<div class="admin-topbar-search" data-admin-search data-open="{{ $search !== '' ? 'true' : 'false' }}">
    <button type="button" class="admin-topbar-icon" data-search-toggle aria-label="Search {{ $label }}" title="Search {{ $label }}" aria-controls="admin-search-form" aria-expanded="{{ $search !== '' ? 'true' : 'false' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
    <form id="admin-search-form" method="get" action="{{ $action ?? url()->current() }}" class="admin-search admin-search--topbar" role="search" @if ($search === '') hidden @endif>
        <label for="admin-search-field" class="sr-only">Search {{ $label }}</label>
        <input id="admin-search-field" name="search" type="search" value="{{ $search }}" placeholder="Search {{ $label }}" autocomplete="off">
        <button type="submit" aria-label="Submit search" title="Search"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
        @if ($search !== '')
            <a href="{{ $action ?? url()->current() }}" class="admin-search__clear" aria-label="Clear search" title="Clear search"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m9 4-6 6 6 6M3 10h11a6 6 0 0 1 0 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
        @endif
        <button type="button" class="admin-search__close" data-search-close aria-label="Close search" title="Close search"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
    </form>
</div>
<script src="{{ asset('js/admin-list-toolbar.js') }}?v={{ filemtime(public_path('js/admin-list-toolbar.js')) }}" defer></script>
