<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <header class="bg-white border-b border-default-200 p-5">
        <div class="mx-auto max-w-6xl flex items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold">Admin dashboard</h1>
        </div>
    </header>
    <main class="mx-auto max-w-6xl p-5 md:p-10">
        <a href="{{ route('admin.editor', ['page' => 'home']) }}" class="inline-flex rounded bg-primary px-6 py-4 font-semibold text-white">🎨 Launch Live Visual Editor</a>
        <h2 class="mt-10 mb-4 text-xl font-semibold">Dynamic collections</h2>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('admin.site-assets.index') }}" class="rounded-lg border border-default-200 bg-white p-5 hover:border-primary">Site media</a>
            <a href="{{ route('admin.brochure') }}" class="rounded-lg border border-default-200 bg-white p-5 hover:border-primary">Download Brochure PDF</a>
            <a href="{{ route('admin.companies.index') }}" class="rounded-lg border border-default-200 bg-white p-5 hover:border-primary">Companies</a>
            <a href="{{ route('admin.certificates.index') }}" class="rounded-lg border border-default-200 bg-white p-5 hover:border-primary">Certificates</a>
            @foreach (config('cms.collections') as $key => $label)
                <a href="{{ route('admin.collections.index', $key) }}" class="rounded-lg border border-default-200 bg-white p-5 hover:border-primary">{{ $label }}</a>
            @endforeach
            <a href="{{ route('admin.contact-submissions.index') }}" class="rounded-lg border border-default-200 bg-white p-5 hover:border-primary">Contact submissions</a>
        </div>
    </main>
</body>
</html>
