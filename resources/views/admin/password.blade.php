<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Change password · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Change password'])</div>
        @if (session('status')) <p role="status" class="mb-5 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        <form method="post" action="{{ route('admin.password.update') }}" class="admin-form-card admin-password-form">
            @csrf
            @method('PUT')
            <div class="admin-form-section">
                <label for="old_password">Current password</label>
                <input id="old_password" name="old_password" type="password" autocomplete="current-password" required>
                @error('old_password') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-section">
                <label for="password">New password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" minlength="12" required>
                @error('password') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-section">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="12" required>
            </div>
            <div class="admin-form-actions"><p>Use at least 12 characters.</p><button type="submit">Update password</button></div>
        </form>
    </main>
</body>
</html>
