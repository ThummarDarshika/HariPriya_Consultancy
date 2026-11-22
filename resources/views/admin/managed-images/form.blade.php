<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>{{ $item->exists ? 'Edit' : 'Add' }} {{ $title }} · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main mx-auto max-w-3xl p-5 md:p-10">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.'.$kind.'.index'), 'title' => ($item->exists ? 'Edit' : 'Add').' '.strtolower($title)])</div>
        <form data-jquery-validation @if ($item->exists) data-admin-confirm-update data-admin-confirm-label="{{ $item->name }}" @endif method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.'.$kind.'.update', $item) : route('admin.'.$kind.'.store') }}" class="admin-form-card space-y-5" novalidate>
            @csrf
            @if ($item->exists) @method('PUT') @endif
            <section class="admin-form-section">
            <label class="block">Image {{ $item->exists ? '' : '*' }}
                <input data-current-image="{{ $item->image_path }}" name="image_upload" data-crop-width="{{ $kind === 'companies' ? 684 : 900 }}" data-crop-height="{{ $kind === 'companies' ? 468 : 1200 }}" type="file" accept="image/png,image/jpeg,image/webp,image/gif" @unless ($item->exists)data-jquery-required="true"@endunless class="mt-2 block w-full">
            </label>
            @error('image_upload')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            <label class="block">Name *
                <input name="name" value="{{ old('name', $item->name) }}" maxlength="255" data-jquery-required="true" class="mt-2 block w-full rounded border border-default-200 p-3">
            </label>
            @error('name')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            </section>
            <div class="admin-form-actions"><button class="rounded bg-primary px-6 py-3 text-white">{{ $item->exists ? 'Save changes' : 'Add '.strtolower($title) }}</button></div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/admin-jquery-validation.js') }}?v={{ filemtime(public_path('js/admin-jquery-validation.js')) }}"></script>
</body>
</html>
