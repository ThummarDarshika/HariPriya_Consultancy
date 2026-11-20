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
            <a href="{{ route('admin.'.$kind.'.create') }}" class="rounded bg-primary px-5 py-3 text-white">Add {{ $kind === 'companies' ? 'company' : 'certificate' }}</a>
        </div>
        @if (session('status')) <p role="status" class="mb-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @include('admin.search', ['label' => strtolower($title), 'action' => route('admin.'.$kind.'.index')])
        @if ($kind === 'companies')
            <p>Drag the handle to change the order. The top logo appears first.</p>
            <p role="status" data-company-order-status></p>
            <div data-company-order data-url="{{ route('admin.companies.reorder') }}" data-token="{{ csrf_token() }}" data-enabled="{{ $search === '' ? 'true' : 'false' }}">
            @if ($search !== '') <p>Clear the search to reorder companies.</p> @endif
        @endif
        @component('admin.list-table', ['headers' => $kind === 'companies' ? ['Move', 'Image', 'Name', 'Status', 'Actions'] : ['Image', 'Name', 'Order', 'Status', 'Actions']])
                    @forelse ($items as $item)
                        <tr class="border-b border-default-100" @if ($kind === 'companies') data-company-id="{{ $item->id }}" @endif>
                            @if ($kind === 'companies')
                                <td><button type="button" class="admin-icon-button" data-drag-handle aria-label="Move {{ $item->name }}. Use arrow keys to reorder." title="Drag to reorder" @disabled($search !== '') style="cursor: grab; touch-action: none">&#x283F;</button></td>
                            @endif
                            <td class="p-4"><img src="{{ $item->image_path }}" alt="{{ $item->name }}" class="admin-list__preview"></td>
                            <td class="p-4">{{ $item->name }}</td>
                            @if ($kind !== 'companies') <td class="p-4">{{ $item->sort_order }}</td> @endif
                            <td class="p-4"><span class="admin-list__status {{ $item->is_active ? 'is-active' : '' }}">{{ $item->is_active ? 'Visible' : 'Hidden' }}</span></td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="admin-action-buttons">
                                    <a class="admin-icon-button" href="{{ route('admin.'.$kind.'.edit', $item) }}" aria-label="Edit {{ $item->name }}" title="Edit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
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
        @if ($kind === 'companies')
            </div>
            @if ($search !== '') <div class="mt-5">{{ $items->links() }}</div> @endif
            <script src="{{ asset('js/company-order.js') }}?v={{ filemtime(public_path('js/company-order.js')) }}" defer></script>
        @else
            <div class="mt-5">{{ $items->links() }}</div>
        @endif
    </main>
</body>
</html>
