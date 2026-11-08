<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Download Brochure · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main admin-wide-main p-5 md:p-10">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Download brochure'])</div>
        @if (session('status')) <p role="status" class="my-4 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @if ($errors->any())
            <div role="alert" class="my-4 rounded bg-red-100 p-4 text-red-900">
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @if ($asset->value)
            <section class="brochure-current" aria-label="Current brochure">
                <div class="brochure-current__file">
                    <span class="brochure-current__symbol" aria-hidden="true">PDF</span>
                    <div>
                        <h2>Current brochure</h2>
                        <p>PDF document <span aria-hidden="true">·</span> Updated {{ $asset->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="brochure-current__actions">
                    <a href="{{ $asset->value }}" target="_blank" rel="noopener">Preview PDF <span aria-hidden="true">↗</span></a>
                    <a href="{{ $asset->value }}" download="Haripriya-Brochure.pdf" class="brochure-current__download">Download PDF <span aria-hidden="true">↓</span></a>
                </div>
            </section>
        @endif

        <form method="post" enctype="multipart/form-data" action="{{ route('admin.site-assets.update', $asset) }}" data-admin-confirm-update data-admin-confirm-label="Download brochure" data-brochure-form class="brochure-upload-card">
            @csrf @method('PUT')
            <div class="brochure-upload-card__heading">
                <div>
                    <h2>{{ $asset->value ? 'Replace brochure' : 'Upload brochure' }}</h2>
                    <p>{{ $asset->value ? 'Choose a new PDF to replace the current brochure.' : 'Choose the PDF you want visitors to download.' }}</p>
                </div>
                <span>PDF only · Max 50 MB</span>
            </div>

            <label class="brochure-dropzone" for="brochure-file">
                <input id="brochure-file" name="upload" type="file" accept="application/pdf,.pdf" aria-describedby="brochure-file-hint brochure-file-selection" @unless ($asset->value) required @endunless>
                <span class="brochure-dropzone__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M12 16V4m0 0L7.5 8.5M12 4l4.5 4.5M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                <strong>Drop your PDF here or <span>browse files</span></strong>
                <small id="brochure-file-hint">A single PDF file, up to 50 MB</small>
            </label>
            <p id="brochure-file-selection" class="brochure-file-selection" aria-live="polite" hidden></p>
            @error('upload') <p class="brochure-file-error" role="alert">{{ $message }}</p> @enderror

            <div class="brochure-upload-card__footer">
                @if ($asset->value)
                    <label class="brochure-remove"><input name="remove" type="checkbox" value="1"> <span>Remove current brochure</span></label>
                @else
                    <p>The PDF will be available after you save it.</p>
                @endif
                <button type="submit" class="brochure-save-button"><span data-brochure-submit-label>{{ $asset->value ? 'Save new brochure' : 'Upload brochure' }}</span> <span aria-hidden="true">→</span></button>
            </div>
        </form>
    </main>
    <script src="{{ asset('js/admin-brochure.js') }}?v={{ filemtime(public_path('js/admin-brochure.js')) }}" defer></script>
</body>
</html>
