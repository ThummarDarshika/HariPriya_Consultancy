<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>{{ $item->exists ? 'Edit' : 'Add' }} project · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/project-media-admin.css') }}?v={{ filemtime(public_path('css/project-media-admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main project-media-admin project-media-form">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.project-media.index'), 'title' => ($item->exists ? 'Edit' : 'Add').' project'])</div>
        <form data-jquery-validation @if ($item->exists) data-admin-confirm-update data-admin-confirm-label="{{ $item->title }}" @endif method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.project-media.update', $item) : route('admin.project-media.store') }}" class="admin-form-card space-y-5" novalidate>
            @csrf
            @if ($item->exists) @method('PUT') @else <input type="hidden" name="media_type" value="{{ $item->media_type }}"> @endif
            @error('media_type')<p class="project-media-upload-error" role="alert">{{ $message }}</p>@enderror
            <section class="admin-form-section">
                @if ($item->file_path && $item->media_type === 'video')
                    <div class="project-media-form__video-preview">
                            <video src="{{ $item->file_path }}" controls preload="metadata" class="project-media-form__video"></video>
                    </div>
                @endif
                <label class="block">{{ $item->media_type === 'video' ? ($item->exists ? 'Replace file' : 'Upload file *') : '' }}
                    <input name="{{ ! $item->exists && $item->media_type === 'image' ? 'media_upload[]' : 'media_upload' }}" @if (! $item->exists && $item->media_type === 'image') multiple @endif type="file" accept="{{ $item->media_type === 'video' ? '.mp4,.webm,.ogg,.ogv,video/mp4,video/webm,video/ogg' : '.jpg,.jpeg,.png,.webp,.gif,image/jpeg,image/png,image/webp,image/gif' }}" data-current-image="{{ $item->media_type === 'image' ? $item->file_path : '' }}" data-crop-width="1200" data-crop-height="900" data-project-media-file data-media-kind="{{ $item->media_type }}" data-max-bytes="{{ $maximumMegabytes * 1048576 }}" @unless ($item->exists)data-requires-file="true"@endunless aria-describedby="project-media-upload-help project-media-upload-error" class="mt-2 block w-full">
                </label>
                <p id="project-media-upload-error" class="project-media-upload-error" data-project-media-error role="alert" @unless ($errors->has('media_upload') || $errors->has('media_upload.*')) hidden @endunless>{{ $errors->first('media_upload') ?: $errors->first('media_upload.*') }}</p>
                @if ($item->media_type === 'video') <p id="project-media-upload-help" class="project-media-upload-help">Supported: {{ $item->media_type === 'video' ? 'MP4, WebM, OGG/OGV' : 'JPG, JPEG, PNG, WebP, GIF' }}. Maximum size: {{ $maximumMegabytes }} MB.</p> @endif
            </section>
            <section class="admin-form-section">
                <label class="block">Title *
                    <input name="title" value="{{ old('title', $item->title) }}" maxlength="255" data-jquery-required="true" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('title')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            </section>
            <div class="admin-form-actions"><button class="rounded bg-primary px-6 py-3 text-white">{{ $item->exists ? 'Save changes' : 'Add '. $item->media_type }}</button></div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/admin-jquery-validation.js') }}?v={{ filemtime(public_path('js/admin-jquery-validation.js')) }}"></script>
    <script src="{{ asset('js/project-media-validation.js') }}?v={{ filemtime(public_path('js/project-media-validation.js')) }}" defer></script>
</body>
</html>
