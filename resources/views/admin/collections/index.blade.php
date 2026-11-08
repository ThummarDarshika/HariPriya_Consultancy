<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>{{ config('cms.collections.'.$collection) }} · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="mx-auto max-w-6xl p-5 md:p-10">
        <div class="admin-page-bar">
            @include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => config('cms.collections.'.$collection)])
            <a href="{{ route('admin.collections.create', $collection) }}" class="rounded bg-primary px-5 py-3 text-white">Add item</a>
        </div>
        @if (session('status')) <p role="status" class="mb-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @include('admin.search', ['label' => strtolower(config('cms.collections.'.$collection))])
        @component('admin.list-table', ['headers' => in_array('category', $visibleFields, true) ? ['Title', 'Category', 'Status', 'Order', 'Actions'] : ['Title', 'Status', 'Order', 'Actions']])
                    @forelse ($items as $item)
                        <tr class="border-b border-default-100">
                            <td class="p-4">{{ $item->title }}</td>
                            @if (in_array('category', $visibleFields, true))<td class="p-4">{{ $item->category }}</td>@endif
                            <td class="p-4"><span class="admin-list__status {{ $item->status === 'published' ? 'is-active' : '' }}">{{ ucfirst($item->status) }}</span></td>
                            <td class="p-4">{{ $item->sort_order }}</td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="admin-action-buttons">
                                    <a class="admin-icon-button" href="{{ route('admin.collections.edit', [$collection, $item]) }}" aria-label="Edit {{ $item->title }}" title="Edit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                    <form method="post" action="{{ route('admin.collections.destroy', [$collection, $item]) }}" class="inline" data-admin-confirm-delete data-admin-confirm-label="{{ $item->title }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-icon-button admin-icon-button--danger" aria-label="Delete {{ $item->title }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ in_array('category', $visibleFields, true) ? 5 : 4 }}" class="p-6 text-center">No items yet.</td></tr>
                    @endforelse
        @endcomponent
        <div class="mt-5">{{ $items->links() }}</div>
    </main>
</body>
</html>
