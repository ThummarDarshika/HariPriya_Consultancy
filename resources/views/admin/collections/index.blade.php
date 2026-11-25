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
        @php
            $dialogItemLabel = match ($collection) { 'products' => 'product', 'services' => 'service', 'blogs' => 'blog', 'testimonials' => 'client review', 'case-studies' => 'case study', 'team-members' => 'team member', 'faqs' => 'FAQ', default => 'item' };
        @endphp
        <div class="admin-page-bar">
            @include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => config('cms.collections.'.$collection)])
            <div class="admin-page-bar__actions">
                @include('admin.search', ['label' => strtolower(config('cms.collections.'.$collection))])
                <a href="{{ route('admin.collections.create', $collection) }}" data-form-dialog-open data-dialog-title="Add {{ $dialogItemLabel }}" class="admin-add-button" aria-label="Add {{ $dialogItemLabel }}" title="Add {{ $dialogItemLabel }}">@include('admin.plus-icon')</a>
            </div>
        </div>
        @if (session('status')) <p role="status" class="mb-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @php
            $hasImage = in_array('image_upload', $visibleFields, true);
            $headers = array_merge($hasImage ? ['Image'] : [], in_array('category', $visibleFields, true) ? ['Title', 'Category', 'Status', 'Actions'] : ['Title', 'Status', 'Actions']);
            $bulkPluralLabel = match ($collection) {
                'products' => 'products',
                'services' => 'services',
                'blogs' => 'blogs',
                'testimonials' => 'client reviews',
                'case-studies' => 'case studies',
                'team-members' => 'team members',
                'faqs' => 'FAQs',
                default => 'items',
            };
        @endphp
        @include('admin.bulk-delete-bar', [
            'formId' => 'bulk-delete-collections-form',
            'action' => route('admin.collections.bulk-destroy', $collection),
            'singular' => $dialogItemLabel,
            'plural' => $bulkPluralLabel,
            'items' => $items,
        ])
        @component('admin.list-table', ['headers' => $headers, 'reorderUrl' => route('admin.order', ['collections', $collection]), 'search' => $search, 'selectable' => true, 'selectLabel' => $bulkPluralLabel])
                    @forelse ($items as $item)
                        <tr data-order-id="{{ $item->id }}">
                            <td class="admin-list__select-col">
                                <input type="checkbox" name="ids[]" value="{{ $item->id }}" form="bulk-delete-collections-form" class="admin-list__checkbox" data-bulk-select-item aria-label="Select {{ $item->title }}">
                            </td>
                            @if ($hasImage)
                                <td class="p-4">@if ($item->image)<img src="{{ $item->image }}" alt="{{ $item->title }}" class="admin-list__preview" loading="lazy">@else<span aria-label="No image">&mdash;</span>@endif</td>
                            @endif
                            <td class="p-4">{{ $item->title }}</td>
                            @if (in_array('category', $visibleFields, true))<td class="p-4">{{ $item->category }}</td>@endif
                            <td class="p-4"><span class="admin-list__status {{ $item->status === 'published' ? 'is-active' : '' }}">{{ ucfirst($item->status) }}</span></td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="admin-action-buttons">
                                    <a class="admin-icon-button" href="{{ route('admin.collections.edit', [$collection, $item]) }}" data-form-dialog-open data-dialog-title="Edit {{ $dialogItemLabel }}" aria-label="Edit {{ $item->title }}" title="Edit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                    <form method="post" action="{{ route('admin.collections.destroy', [$collection, $item]) }}" class="inline" data-admin-confirm-delete data-admin-confirm-label="{{ $item->title }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-icon-button admin-icon-button--danger" aria-label="Delete {{ $item->title }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($headers) + 1 }}" class="p-6 text-center">No items yet.</td></tr>
                    @endforelse
        @endcomponent
        <div class="mt-5">@if ($search !== '') {{ $items->links() }} @endif</div>
    </main>
    @include('admin.form-dialog')
</body>
</html>
