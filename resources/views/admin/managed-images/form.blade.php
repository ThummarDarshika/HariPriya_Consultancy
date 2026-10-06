<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $item->exists ? 'Edit' : 'Add' }} {{ $title }} · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main mx-auto max-w-3xl p-5 md:p-10">
        <a class="admin-back-link" href="{{ route('admin.'.$kind.'.index') }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>{{ ucfirst($kind) }}</span></a>
        <div class="admin-form-heading"><div><p class="admin-form-eyebrow">{{ $title }}</p><h1>{{ $item->exists ? 'Edit' : 'Add' }} {{ strtolower($title) }}</h1><p>Keep your website imagery organized and up to date.</p></div><span class="admin-form-badge">{{ $item->exists ? 'Editing' : 'New item' }}</span></div>
        <form data-jquery-validation method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.'.$kind.'.update', $item) : route('admin.'.$kind.'.store') }}" class="admin-form-card space-y-5" novalidate>
            @csrf
            @if ($item->exists) @method('PUT') @endif
            <section class="admin-form-section">
                <div class="admin-form-section__heading"><span>01</span><div><h2>{{ $title }} details</h2><p>Name and display settings</p></div></div>
            <label class="block">Name *
                <input name="name" value="{{ old('name', $item->name) }}" maxlength="255" data-jquery-required="true" class="mt-2 block w-full rounded border border-default-200 p-3">
            </label>
            @error('name')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            <label class="block">Image {{ $item->exists ? '' : '*' }}
                @if ($item->image_path)
                    <img src="{{ $item->image_path }}" alt="Current {{ strtolower($title) }} image" class="my-3 h-28 w-40 object-contain">
                @endif
                <input name="image_upload" type="file" accept="image/png,image/jpeg,image/webp,image/gif" @unless ($item->exists)data-jquery-required="true"@endunless class="mt-2 block w-full">
            </label>
            @error('image_upload')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            <p>PNG, JPEG, WebP or GIF, up to 5 MB.</p>
            <label class="block">Order index *
                <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}" data-jquery-required="true" class="mt-2 block w-full rounded border border-default-200 p-3">
            </label>
            @error('sort_order')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            <label class="flex items-center gap-2">
                <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $item->is_active))>
                Show on website
            </label>
            </section>
            <div class="admin-form-actions"><p>Changes are saved to your website content.</p><button class="rounded bg-primary px-6 py-3 text-white">Save {{ strtolower($title) }}</button></div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/admin-jquery-validation.js') }}?v={{ filemtime(public_path('js/admin-jquery-validation.js')) }}"></script>
</body>
</html>
