<form method="get" action="{{ $action ?? url()->current() }}" class="admin-search" role="search">
    <label for="admin-search-field" class="sr-only">Search {{ $label }}</label>
    <input id="admin-search-field" name="search" type="search" value="{{ $search }}" placeholder="Search" autocomplete="off">
    <button type="submit">Search</button>
    @if ($search !== '')
        <a href="{{ $action ?? url()->current() }}" class="admin-search__clear">Clear</a>
    @endif
</form>
