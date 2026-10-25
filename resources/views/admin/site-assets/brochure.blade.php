<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Download Brochure · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main mx-auto max-w-3xl p-5 md:p-10">
        <a class="admin-back-link" href="{{ route('admin.dashboard') }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Dashboard</span></a>
        <div class="admin-form-heading"><div><p class="admin-form-eyebrow">Site settings</p><h1>Download brochure</h1><p>This PDF is used by every brochure button on your website.</p></div><span class="admin-form-badge">PDF</span></div>
        @if (session('status')) <p role="status" class="my-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @if ($errors->any())
            <div role="alert" class="my-4 rounded bg-red-100 p-4 text-red-900">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="post" enctype="multipart/form-data" action="{{ route('admin.site-assets.update', $asset) }}" data-admin-confirm-update data-admin-confirm-label="Download brochure" class="admin-form-card admin-brochure-card">
            @csrf @method('PUT')
            @if ($asset->value)
                <p class="mb-4"><a href="{{ $asset->value }}" target="_blank" rel="noopener" class="underline">View current brochure</a></p>
            @else
                <p class="mb-4">No brochure uploaded yet.</p>
            @endif
            <label class="block font-medium">Upload PDF
                <input name="upload" type="file" accept="application/pdf" class="mt-2 block w-full">
            </label>
            @if ($asset->value)
                <label class="mt-4 flex items-center gap-2"><input name="remove" type="checkbox" value="1"> Remove brochure</label>
            @endif
            <div class="admin-form-actions"><p>Upload a PDF up to 5 MB.</p><button class="rounded bg-primary px-6 py-3 text-white">Save brochure</button></div>
        </form>
    </main>
</body>
</html>
