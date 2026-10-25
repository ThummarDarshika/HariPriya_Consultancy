<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ count($cmsInitialContent ?? []) ? 'cms-content-pending' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HARIPRIYA - Manufacturing Services')</title>
    
    <!-- Meta Tags -->
    <meta name="title" content="@yield('meta_title', 'HARIPRIYA - Manufacturing Services')">
    <meta name="description" content="@yield('meta_description', 'Professional Manufacturing Services Website Template built with TailwindCSS 4. Ideal for factories, industrial companies, production plants, and engineering businesses. Fully responsive, modern, and easy to customize.')">
    <meta name="keywords" content="manufacturing website template, industrial website, factory website template, tailwind css manufacturing template, production company website, engineering services template, industrial tailwind template">
    <meta name="author" content="Haripriya">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="cms-page" content="{{ $cmsEditorPage ?? $cmsPage ?? request()->route()?->getName() ?? 'home' }}">
    <meta name="cms-content-url" content="{{ route('site-content.index') }}">
    <meta name="cms-collections-url" content="{{ url('/api/collections') }}">
    <meta name="cms-blog-detail-url" content="{{ route('blog-detail') }}">
    <style>html.cms-content-pending body { visibility: hidden; }</style>
    <noscript><style>html.cms-content-pending body { visibility: visible; }</style></noscript>
    <script>window.siteContentInitial = {{ Illuminate\Support\Js::from($cmsInitialContent ?? []) }};</script>
    @isset($cmsEditorPage)
        <meta name="cms-save-url" content="{{ route('site-content.save') }}">
    @endisset
    
    <!-- Favicon -->
    <link rel="icon" href="{{ $siteAssets['site.favicon'] ?? asset('assets/favicon-D5yOChkQ.svg') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-effects.css') }}?v={{ filemtime(public_path('css/site-effects.css')) }}">
    @isset($cmsEditorPage)
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    @endisset
    @isset($cmsEditorPage)
        <link rel="stylesheet" href="{{ asset('css/editor.css') }}?v={{ filemtime(public_path('css/editor.css')) }}">
    @endisset
    
    <!-- Scripts -->
    <script type="module" src="{{ asset('assets/app-MYA1z5jW.js') }}"></script>
    <script src="{{ asset('js/site-content.js') }}?v={{ filemtime(public_path('js/site-content.js')) }}" defer></script>
    <script src="{{ asset('js/collection-content.js') }}" defer></script>
    <script src="{{ asset('js/product-gallery.js') }}?v={{ filemtime(public_path('js/product-gallery.js')) }}" defer></script>
    @isset($cmsEditorPage)
        <script src="{{ asset('js/editor.js') }}?v={{ filemtime(public_path('js/editor.js')) }}" defer></script>
    @endisset
    
    @stack('styles')
</head>
<body class="bg-white text-default-800 antialiased {{ isset($cmsEditorPage) ? 'has-admin-sidebar admin-sidebar-collapsed' : '' }}">

    @isset($cmsEditorPage)
        @include('admin.sidebar')
    @endisset

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @isset($cmsEditorPage)
        @include('admin.editor-toolbar')
    @endisset

    @stack('scripts')
</body>
</html>
