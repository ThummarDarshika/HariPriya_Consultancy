<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project media · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/project-media-admin.css') }}?v={{ filemtime(public_path('css/project-media-admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-content-main project-media-admin project-media-admin--index">
        <a class="admin-back-link" href="{{ route('admin.dashboard') }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Dashboard</span></a>
        <div class="project-media-heading">
            <div class="project-media-heading__copy"><p class="project-media-eyebrow">Projects page</p><h1>Project media</h1><p>Upload images and videos, set their titles, and choose what appears on the website.</p></div>
            <div class="project-media-actions">
                <a href="{{ route('admin.project-media.create', ['type' => 'image']) }}" class="project-media-action project-media-action--image"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><circle cx="8" cy="9" r="1.5" fill="currentColor"/><path d="m4 17 5-5 3 3 3-4 5 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>Add image</a>
                <a href="{{ route('admin.project-media.create', ['type' => 'video']) }}" class="project-media-action project-media-action--video"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="m10 8 6 4-6 4V8Z" fill="currentColor"/></svg>Add video</a>
            </div>
        </div>
        @if (session('status')) <p role="status" class="mb-5 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif

        <form method="get" class="mb-5 flex gap-2">
            <input name="search" value="{{ $search }}" placeholder="Search title or type" class="w-full max-w-md rounded border border-default-200 p-3">
            <button class="rounded bg-default-900 px-5 text-white">Search</button>
        </form>

        @if ($items->isNotEmpty())
            <div class="project-media-table-wrap">
                <table class="project-media-table">
                    <thead><tr><th scope="col">Preview</th><th scope="col">Title</th><th scope="col">Type</th><th scope="col">Status</th><th scope="col">Order</th><th scope="col">Actions</th></tr></thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <div class="project-media-table__preview">
                                        @if ($item->media_type === 'video')
                                            <video src="{{ $item->file_path }}" aria-label="{{ $item->title }}" controls preload="metadata"></video>
                                        @else
                                            <img src="{{ $item->file_path }}" alt="{{ $item->title }}" loading="lazy">
                                        @endif
                                    </div>
                                </td>
                                <td class="project-media-table__title">{{ $item->title }}</td>
                                <td><span class="project-media-table__type">{{ ucfirst($item->media_type) }}</span></td>
                                <td><span class="project-media-table__status {{ $item->is_active ? 'project-media-table__status--visible' : 'project-media-table__status--hidden' }}">{{ $item->is_active ? 'Visible' : 'Hidden' }}</span></td>
                                <td>{{ $item->sort_order }}</td>
                                <td>
                                    <div class="admin-action-buttons">
                                        <a class="admin-icon-button" href="{{ route('admin.project-media.edit', $item) }}" aria-label="Edit {{ $item->title }}" title="Edit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                        <form method="post" action="{{ route('admin.project-media.destroy', $item) }}" data-admin-confirm-delete data-admin-confirm-label="{{ $item->title }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="admin-icon-button admin-icon-button--danger" aria-label="Delete {{ $item->title }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="project-media-empty">
                <span class="project-media-empty__icon" aria-hidden="true"><svg viewBox="0 0 64 64" fill="none"><rect x="8" y="12" width="48" height="40" rx="7" stroke="currentColor" stroke-width="2.5"/><circle cx="23" cy="25" r="4" fill="currentColor"/><path d="m11 46 13-13 9 9 8-10 12 14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="47" cy="46" r="12" fill="#fff" stroke="currentColor" stroke-width="2.5"/><path d="M43 46h8m-4-4v8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></span>
                <p class="project-media-eyebrow">Your gallery starts here</p>
                @if ($search !== '')
                    <h2>No matching project media</h2>
                    <p>Try another title or type.</p>
                @else
                    <h2>No project media yet</h2>
                    <p>Add the first image or video to show your work on the Projects page.</p>
                    <div class="project-media-actions">
                        <a href="{{ route('admin.project-media.create', ['type' => 'image']) }}" class="project-media-action project-media-action--image">Add image</a>
                        <a href="{{ route('admin.project-media.create', ['type' => 'video']) }}" class="project-media-action project-media-action--video">Add video</a>
                    </div>
                @endif
            </div>
        @endif
        <div class="mt-8">{{ $items->links() }}</div>
    </main>
</body>
</html>
