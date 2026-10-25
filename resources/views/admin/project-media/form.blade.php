<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $item->exists ? 'Edit' : 'Add' }} project {{ $item->media_type }} · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/project-media-admin.css') }}?v={{ filemtime(public_path('css/project-media-admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main project-media-admin project-media-form">
        <a class="admin-back-link" href="{{ route('admin.project-media.index') }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Project media</span></a>
        <div class="admin-form-heading"><div><p class="admin-form-eyebrow">Projects page</p><h1>{{ $item->exists ? 'Edit' : 'Add' }} {{ $item->media_type }}</h1><p>Manage the file and title shown in the project gallery.</p></div><span class="admin-form-badge">{{ $item->exists ? 'Editing' : 'New item' }}</span></div>
        <form data-jquery-validation @if ($item->exists) data-admin-confirm-update data-admin-confirm-label="{{ $item->title }}" @endif method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.project-media.update', $item) : route('admin.project-media.store') }}" class="admin-form-card space-y-5" novalidate>
            @csrf
            @if ($item->exists) @method('PUT') @else <input type="hidden" name="media_type" value="{{ $item->media_type }}"> @endif
            @error('media_type')<p class="project-media-upload-error" role="alert">{{ $message }}</p>@enderror
            <section class="admin-form-section">
                <div class="admin-form-section__heading"><span>01</span><div><h2>Gallery details</h2><p>The title is managed here and appears below the {{ $item->media_type }}.</p></div></div>
                <label class="block">Title *
                    <input name="title" value="{{ old('title', $item->title) }}" maxlength="255" data-jquery-required="true" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('title')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                <div class="project-media-settings">
                    <div>
                        <label class="block">Display order *
                            <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}" data-jquery-required="true" class="mt-2 block w-full rounded border border-default-200 p-3">
                        </label>
                        @error('sort_order')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input name="is_active" type="hidden" value="0">
                        <label class="project-media-visibility">
                            <input name="is_active" type="checkbox" value="1" @checked(old('is_active', $item->is_active))>
                            <span class="project-media-visibility__copy"><strong>Show on website</strong><small>Visible on the public Projects page after saving.</small></span>
                        </label>
                    </div>
                </div>
            </section>
            <section class="admin-form-section">
                <div class="admin-form-section__heading"><span>02</span><div><h2>{{ ucfirst($item->media_type) }} file</h2><p>{{ $item->exists ? 'Upload a new file only if you want to replace the current one.' : 'Choose the file to show on the Projects page.' }}</p></div></div>
                @if ($item->file_path)
                    <div class="overflow-hidden rounded-lg bg-default-900">
                        @if ($item->media_type === 'video')
                            <video src="{{ $item->file_path }}" controls preload="metadata" class="max-h-72 w-full object-contain"></video>
                        @else
                            <img src="{{ $item->file_path }}" alt="Current project image" class="max-h-72 w-full object-contain">
                        @endif
                    </div>
                @endif
                <label class="block">{{ $item->exists ? 'Replace file' : 'Upload file *' }}
                    <input name="media_upload" type="file" accept="{{ $item->media_type === 'video' ? '.mp4,.webm,.ogg,.ogv,video/mp4,video/webm,video/ogg' : '.jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif' }}" data-project-media-file data-media-kind="{{ $item->media_type }}" data-max-bytes="{{ $maximumMegabytes * 1048576 }}" @unless ($item->exists)data-requires-file="true"@endunless aria-describedby="project-media-upload-help project-media-upload-error" class="mt-2 block w-full">
                </label>
                <p id="project-media-upload-error" class="project-media-upload-error" data-project-media-error role="alert" @unless ($errors->has('media_upload')) hidden @endunless>@error('media_upload'){{ $message }}@enderror</p>
                <p id="project-media-upload-help" class="project-media-upload-help">Supported: {{ $item->media_type === 'video' ? 'MP4, WebM, OGG/OGV' : 'JPG, JPEG, PNG, WebP, GIF' }}. Maximum size: {{ $maximumMegabytes }} MB.</p>
            </section>
            <div class="admin-form-actions"><p>Changes appear on the Projects page after saving.</p><button class="rounded bg-primary px-6 py-3 text-white">Save {{ $item->media_type }}</button></div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/admin-jquery-validation.js') }}?v={{ filemtime(public_path('js/admin-jquery-validation.js')) }}"></script>
    <script src="{{ asset('js/project-media-validation.js') }}?v={{ filemtime(public_path('js/project-media-validation.js')) }}" defer></script>
</body>
</html>
