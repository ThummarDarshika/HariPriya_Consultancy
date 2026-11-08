<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>{{ $jobApplication->full_name }} · Job application · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/career-admin.css') }}?v={{ filemtime(public_path('css/career-admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-content-main career-admin">
        <div class="admin-page-bar">
            @include('admin.back-link', ['href' => route('admin.job-applications.index'), 'title' => $jobApplication->full_name])
            <a class="career-admin__primary" href="{{ route('admin.job-applications.resume', $jobApplication) }}">Download resume</a>
        </div>
        <div class="career-admin__detail">
            <dl>
                <div><dt>Role</dt><dd>{{ $jobApplication->role_title }}</dd></div>
                <div><dt>Submitted</dt><dd>{{ $jobApplication->created_at->copy()->setTimezone(config('app.display_timezone'))->format('d M Y, h:i A T') }}</dd></div>
                <div><dt>Email</dt><dd><a href="mailto:{{ $jobApplication->email }}">{{ $jobApplication->email }}</a></dd></div>
                <div><dt>Phone</dt><dd>{{ $jobApplication->phone }}</dd></div>
                <div><dt>Location</dt><dd>{{ $jobApplication->location }}</dd></div>
                <div><dt>Qualification</dt><dd>{{ $jobApplication->qualification }}</dd></div>
                <div><dt>Experience</dt><dd>{{ $jobApplication->experience_years }} years</dd></div>
                <div><dt>Current company</dt><dd>{{ $jobApplication->current_company ?: '—' }}</dd></div>
                <div><dt>Notice period</dt><dd>{{ $jobApplication->notice_period ?: '—' }}</dd></div>
            </dl>
            <div class="career-admin__letter"><h2>Why this role</h2><p>{{ $jobApplication->cover_letter }}</p></div>
        </div>
    </main>
</body>
</html>
