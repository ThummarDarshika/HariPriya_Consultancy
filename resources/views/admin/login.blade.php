<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <label class="block">Password
            <input name="password" type="password" autocomplete="current-password" required class="mt-2 block w-full rounded border border-default-200 p-3">
        </label>
        <button class="w-full rounded bg-default-900 p-3 text-white">Sign in</button>
    </form>
</body>
</html>
