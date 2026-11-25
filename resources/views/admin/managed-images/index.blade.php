<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>{{ $title }} · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="mx-auto max-w-6xl p-5 md:p-10">
        <div class="admin-page-bar">
            @include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => $title])
            <div class="admin-page-bar__actions">
                @include('admin.search', ['label' => strtolower($title), 'action' => route('admin.'.$kind.'.index')])
                <a href="{{ route('admin.'.$kind.'.create') }}" data-company-open class="admin-add-button" aria-label="Add {{ $kind === 'companies' ? 'company' : 'certificate' }}" title="Add {{ $kind === 'companies' ? 'company' : 'certificate' }}">@include('admin.plus-icon')</a>
            </div>
        </div>
        @if (session('status')) <p role="status" class="mb-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @php
            $bulkFormId = 'bulk-delete-'.$kind.'-form';
            $bulkSingular = $kind === 'companies' ? 'company' : 'certificate';
        @endphp
        @include('admin.bulk-delete-bar', [
            'formId' => $bulkFormId,
            'action' => route('admin.'.$kind.'.bulk-destroy'),
            'singular' => $bulkSingular,
            'plural' => $kind,
            'items' => $items,
        ])
        @component('admin.list-table', ['headers' => ['Image', 'Name', 'Status', 'Actions'], 'reorderUrl' => route('admin.order', $kind), 'search' => $search, 'selectable' => true, 'selectLabel' => $kind])
                    @forelse ($items as $item)
                        <tr class="border-b border-default-100" data-order-id="{{ $item->id }}">
                            <td class="admin-list__select-col">
                                <input type="checkbox" name="ids[]" value="{{ $item->id }}" form="{{ $bulkFormId }}" class="admin-list__checkbox" data-bulk-select-item aria-label="Select {{ $item->name }}">
                            </td>
                            <td class="p-4"><img src="{{ $item->image_path }}" alt="{{ $item->name }}" class="admin-list__preview"></td>
                            <td class="p-4">{{ $item->name }}</td>
                            <td class="p-4"><span class="admin-list__status {{ $item->is_active ? 'is-active' : '' }}">{{ $item->is_active ? 'Visible' : 'Hidden' }}</span></td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="admin-action-buttons">
                                    <a class="admin-icon-button" href="{{ route('admin.'.$kind.'.edit', $item) }}" data-company-open data-company-name="{{ $item->name }}" data-company-image="{{ $item->image_path }}" data-company-action="{{ route('admin.'.$kind.'.update', $item) }}" aria-label="Edit {{ $item->name }}" title="Edit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                    <form method="post" action="{{ route('admin.'.$kind.'.destroy', $item) }}" class="inline" data-admin-confirm-delete data-admin-confirm-label="{{ $item->name }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-icon-button admin-icon-button--danger" aria-label="Delete {{ $item->name }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center">No items yet.</td></tr>
                    @endforelse
        @endcomponent
        @if ($search !== '') <div class="mt-5">{{ $items->links() }}</div> @endif
    </main>
    @include('admin.managed-images.company-dialog')
        <script src="{{ asset('js/company-dialog.js') }}?v={{ filemtime(public_path('js/company-dialog.js')) }}" defer></script>
</body>
</html>
