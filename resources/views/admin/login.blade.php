<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Administrator sign in</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel admin-login min-h-screen bg-default-100 text-default-900 flex items-center justify-center p-5">
    <form method="post" action="{{ route('admin.login.store') }}" class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg space-y-5">
        @csrf
        <h1 class="text-2xl font-semibold">Administrator sign in</h1>
        @if (session('admin-auth-required'))
            <p role="alert" class="text-amber-800">Sign in to the admin panel, then return to your previous page and retry the action.</p>
        @endif
        @if ($errors->any())
            <p role="alert" class="text-red-700">{{ $errors->first() }}</p>
        @endif
        <label class="block">Email
            <input name="email" type="email" value="{{ old('email') }}" autocomplete="username" required class="mt-2 block w-full rounded border border-default-200 p-3">
        </label>
        <div>
            <label for="admin-login-password">Password</label>
            <div class="admin-login-password">
                <input id="admin-login-password" name="password" type="password" autocomplete="current-password" required class="mt-2 block w-full rounded border border-default-200 p-3">
                <button type="button" class="admin-login-password__toggle" aria-controls="admin-login-password" aria-label="Show password" aria-pressed="false" title="Show password" data-password-toggle>
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.8"/><path d="M4 4 20 20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" data-password-slash hidden/></svg>
                </button>
            </div>
        </div>
        <button class="w-full rounded bg-default-900 p-3 text-white">Sign in</button>
    </form>
    <script>
        const passwordInput = document.getElementById('admin-login-password');
        const passwordToggle = document.querySelector('[data-password-toggle]');
        passwordToggle.addEventListener('click', () => {
            const isVisible = passwordInput.type === 'password';
            passwordInput.type = isVisible ? 'text' : 'password';
            passwordToggle.setAttribute('aria-pressed', String(isVisible));
            passwordToggle.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');
            passwordToggle.setAttribute('title', isVisible ? 'Hide password' : 'Show password');
            passwordToggle.querySelector('[data-password-slash]').hidden = !isVisible;
        });
    </script>
</body>
</html>
