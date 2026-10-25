<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Site media · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-content-main mx-auto max-w-6xl p-5 md:p-10">
        <a class="admin-back-link" href="{{ route('admin.dashboard') }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Dashboard</span></a>
        <div class="admin-form-heading"><div><p class="admin-form-eyebrow">Site settings</p><h1>Site media</h1><p>Manage images and fixed content used across your website.</p></div></div>
        @if (session('status')) <p role="status" class="my-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @if ($errors->any())
            <div role="alert" class="my-4 rounded bg-red-100 p-4 text-red-900">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @foreach ($assetGroups as $page => $assets)
            <h2 class="mt-10 mb-4 text-xl font-semibold">{{ ucfirst(str_replace('-', ' ', $page)) }}</h2>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($assets as $asset)
                    <form method="post" enctype="multipart/form-data" action="{{ route('admin.site-assets.update', $asset) }}" data-admin-confirm-update data-admin-confirm-label="{{ $asset->label }}" class="admin-asset-card">
                        @csrf @method('PUT')
                        <h3 class="mb-3 text-lg font-semibold">{{ $asset->label }}</h3>
                        @if ($asset->kind === 'text')
                            <label>Text
                                <input name="value" value="{{ old('value', $asset->value) }}" required maxlength="160" class="mt-2 block w-full rounded border border-default-200 p-3">
                            </label>
                        @elseif ($asset->kind === 'document')
                            @if ($asset->value)
                                <p class="mb-3"><a href="{{ $asset->value }}" target="_blank" rel="noopener" class="underline">View current brochure</a></p>
                            @else
                                <p class="mb-3">No brochure uploaded yet.</p>
                            @endif
                            <label>Upload PDF
                                <input name="upload" type="file" accept="application/pdf" class="mt-2 block w-full">
                            </label>
                            @if ($asset->value)
                                <label class="mt-3 flex items-center gap-2"><input name="remove" type="checkbox" value="1"> Remove brochure</label>
                            @endif
                        @else
                            @if ($asset->value)
                                <img src="{{ $asset->value }}" alt="{{ $asset->label }}" class="admin-asset-preview {{ str_starts_with($asset->key, 'about.team_avatar_') ? 'admin-asset-preview--team' : '' }} mb-3 h-28 w-full rounded object-contain">
                            @endif
                            <label>Upload image
                                <input name="upload" type="file" accept="image/png,image/jpeg,image/webp,image/gif,image/svg+xml,image/x-icon" required class="mt-2 block w-full">
                            </label>
                        @endif
                        @if ($asset->kind !== 'text') <p class="mt-2 text-sm">Maximum file size: 5 MB.</p> @endif
                        <button class="mt-4 rounded bg-primary px-5 py-3 text-white">Save</button>
                    </form>
                @endforeach
            </div>
        @endforeach
    </main>
</body>
</html>
