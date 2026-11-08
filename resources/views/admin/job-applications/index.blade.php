<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Job applications · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/career-admin.css') }}?v={{ filemtime(public_path('css/career-admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-content-main career-admin">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Job applications'])</div>
        @if (session('status')) <p role="status" class="career-admin__notice">{{ session('status') }}</p> @endif
        @include('admin.search', ['label' => 'job applications'])
        @component('admin.list-table', ['headers' => ['Candidate', 'Role', 'Phone', 'Applied', 'Actions']])
            @forelse ($applications as $application)
                <tr>
                    <td><strong>{{ $application->full_name }}</strong><small>{{ $application->email }}</small></td>
                    <td>{{ $application->role_title }}</td>
                    <td>{{ $application->phone }}</td>
                    <td>{{ $application->created_at->copy()->setTimezone(config('app.display_timezone'))->format('d M Y, h:i A T') }}</td>
                    <td><div class="admin-action-buttons">
                        <a class="admin-icon-button" href="{{ route('admin.job-applications.show', $application) }}" aria-label="View {{ $application->full_name }}" title="View details"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.8"/></svg></a>
                        <form method="post" action="{{ route('admin.job-applications.destroy', $application) }}" data-admin-confirm-delete data-admin-confirm-label="{{ $application->full_name }}">@csrf @method('DELETE')<button type="submit" class="admin-icon-button admin-icon-button--danger" aria-label="Delete {{ $application->full_name }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="5" class="admin-list__empty">{{ $search ? 'No matching applications.' : 'No applications received yet.' }}</td></tr>
            @endforelse
        @endcomponent
        <div class="admin-list__pagination">{{ $applications->links() }}</div>
    </main>
</body>
</html>
