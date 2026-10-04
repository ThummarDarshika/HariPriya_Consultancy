<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Manufactt - Manufacturing Services Website')</title>
    
    <!-- Meta Tags -->
    <meta name="title" content="@yield('meta_title', 'Manufactt - Manufacturing Services Website TailwindCSS 4 Template')">
    <meta name="description" content="@yield('meta_description', 'Professional Manufacturing Services Website Template built with TailwindCSS 4. Ideal for factories, industrial companies, production plants, and engineering businesses. Fully responsive, modern, and easy to customize.')">
    <meta name="keywords" content="manufacturing website template, industrial website, factory website template, tailwind css manufacturing template, production company website, engineering services template, industrial tailwind template">
    <meta name="author" content="Unifato">
    <meta name="robots" content="index, follow">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon-D5yOChkQ.svg') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    
    <!-- Scripts -->
    <script type="module" src="{{ asset('assets/app-MYA1z5jW.js') }}"></script>
    
    @stack('styles')
</head>
<body class="bg-white text-default-800 antialiased">

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
