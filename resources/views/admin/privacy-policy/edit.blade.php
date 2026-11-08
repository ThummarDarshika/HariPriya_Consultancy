<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Privacy Policy · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/privacy-policy.css') }}?v={{ filemtime(public_path('css/privacy-policy.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')

    <main class="admin-form-main admin-wide-main privacy-policy-admin">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Privacy Policy'])</div>

        @if (session('status'))
            <p class="privacy-policy-admin__notice" role="status">{{ session('status') }}</p>
        @endif
        @if ($errors->any())
            <div class="privacy-policy-admin__errors" role="alert">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form method="post" action="{{ route('admin.privacy-policy.update') }}" class="privacy-policy-editor" data-privacy-policy-form data-admin-confirm-update data-admin-confirm-label="Privacy Policy">
            @csrf
            @method('PUT')

            <div class="privacy-policy-editor__toolbar" role="toolbar" aria-label="Text formatting">
                <div class="privacy-policy-editor__tool-group">
                    <button type="button" data-editor-command="bold" aria-label="Bold" title="Bold"><strong>B</strong></button>
                    <button type="button" data-editor-command="italic" aria-label="Italic" title="Italic"><em>I</em></button>
                    <button type="button" data-editor-command="underline" aria-label="Underline" title="Underline"><u>U</u></button>
                </div>
                <div class="privacy-policy-editor__tool-group">
                    <button type="button" data-editor-command="formatBlock" data-editor-value="h2" aria-label="Heading" title="Heading">H2</button>
                    <button type="button" data-editor-command="formatBlock" data-editor-value="p" aria-label="Paragraph" title="Paragraph">P</button>
                </div>
                <div class="privacy-policy-editor__tool-group">
                    <button type="button" data-editor-command="insertUnorderedList" aria-label="Bullet list" title="Bullet list">• List</button>
                    <button type="button" data-editor-command="insertOrderedList" aria-label="Numbered list" title="Numbered list">1. List</button>
                </div>
                <div class="privacy-policy-editor__tool-group">
                    <button type="button" data-editor-size="decrease" aria-label="Decrease text size" title="Decrease text size">A−</button>
                    <button type="button" data-editor-size="increase" aria-label="Increase text size" title="Increase text size">A+</button>
                </div>
            </div>

            <div class="privacy-policy-content privacy-policy-editor__surface" contenteditable="true" role="textbox" aria-label="Privacy Policy content" aria-multiline="true" data-privacy-policy-content>{!! $bodyHtml !!}</div>
            <textarea name="body_html" hidden aria-hidden="true" data-privacy-policy-field></textarea>
            <p class="privacy-policy-editor__field-error" role="alert" data-privacy-policy-error hidden>Add some Privacy Policy content before saving.</p>

            <div class="admin-form-actions">
                <p>Saved formatting appears on the public Privacy Policy page immediately.</p>
                <button type="submit" class="rounded bg-primary px-6 py-3 text-white">Save and publish</button>
            </div>
        </form>
    </main>
    <script src="{{ asset('js/privacy-policy-editor.js') }}?v={{ filemtime(public_path('js/privacy-policy-editor.js')) }}" defer></script>
</body>
</html>
