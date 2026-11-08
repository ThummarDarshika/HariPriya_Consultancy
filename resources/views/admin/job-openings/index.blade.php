<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Job openings · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/career-admin.css') }}?v={{ filemtime(public_path('css/career-admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-content-main career-admin">
        <div class="admin-page-bar">
            @include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Job openings'])
            <a class="career-admin__primary" href="{{ route('admin.job-openings.create') }}">+ Add opening</a>
        </div>
        @if (session('status')) <p role="status" class="career-admin__notice">{{ session('status') }}</p> @endif
        @include('admin.search', ['label' => 'job openings'])
        @component('admin.list-table', ['headers' => ['Role', 'Department', 'Location', 'Status', 'Applications', 'Actions']])
            @forelse ($items as $item)
                <tr>
                    <td><strong>{{ $item->title }}</strong><small>{{ $item->employment_type }}</small></td>
                    <td>{{ $item->department }}</td>
                    <td>{{ $item->location }}</td>
                    <td><span class="admin-list__status {{ $item->is_active ? 'is-active' : '' }}">{{ $item->is_active ? 'Open' : 'Hidden' }}</span></td>
                    <td>{{ $item->applications_count }}</td>
                    <td><div class="admin-action-buttons"><a class="admin-icon-button" href="{{ route('admin.job-openings.edit', $item) }}" aria-label="Edit {{ $item->title }}" title="Edit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="m14 5 5 5M4 20l4.5-1 11-11a2.12 2.12 0 0 0-3-3l-11 11L4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a><form method="post" action="{{ route('admin.job-openings.destroy', $item) }}" data-admin-confirm-delete data-admin-confirm-label="{{ $item->title }}">@csrf @method('DELETE')<button class="admin-icon-button admin-icon-button--danger" type="submit" aria-label="Delete {{ $item->title }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="admin-list__empty">{{ $search ? 'No matching job openings.' : 'No job openings yet. Add the first role to show it on the Career page.' }}</td></tr>
            @endforelse
        @endcomponent
        <div class="admin-list__pagination">{{ $items->links() }}</div>
    </main>
</body>
</html>
