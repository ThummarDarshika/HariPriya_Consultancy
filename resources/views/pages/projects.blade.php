@extends('layouts.app')

@section('title', 'Projects | HARIPRIYA')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}?v={{ filemtime(public_path('css/projects.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/inner-page-banner.css') }}?v={{ filemtime(public_path('css/inner-page-banner.css')) }}">
@endpush

@section('content')
    <section class="projects-hero inner-page-banner relative overflow-hidden bg-default-100 text-default-900">
        @include('partials.inner-page-banner-effects')

        <div class="container relative z-10">
            <div class="projects-hero__copy">
                <p class="projects-eyebrow mb-6 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium"><span class="size-2 bg-primary" data-cms-ignore></span>Selected work</p>
                <h1 class="projects-title max-w-3xl font-semibold leading-tight tracking-tight">Projects built to perform</h1>
                <p class="projects-intro mt-7 max-w-2xl leading-relaxed">Explore the work behind our manufacturing solutions through project images and videos.</p>
            </div>
        </div>
    </section>

    <section id="project-gallery" class="projects-gallery bg-white">
        <div class="container">
            <div class="projects-gallery__heading mb-10 flex flex-wrap items-end justify-between gap-5 border-b border-default-200 pb-7">
                <div>
                    <span class="mb-3 block text-sm font-semibold uppercase tracking-[0.2em] text-primary">Project gallery</span>
                    <h2 class="text-3xl font-semibold tracking-tight text-default-900 md:text-4xl">A closer look at our work</h2>
                </div>
                <span class="text-sm font-medium text-default-500" data-cms-ignore>{{ $projectMedia->total() }} {{ Str::plural('project', $projectMedia->total()) }}</span>
            </div>

            <div class="projects-grid grid gap-7" data-cms-collection="project-media">
                @forelse ($projectMedia as $item)
                    <article class="projects-card group overflow-hidden rounded-2xl border border-default-200 bg-white shadow-sm transition-all duration-300">
                        <div class="projects-card__media relative overflow-hidden bg-default-900">
                            @if ($item->media_type === 'video')
                                <video src="{{ $item->file_path }}" aria-label="{{ $item->title }}" controls playsinline preload="metadata" class="projects-card__file size-full object-cover"></video>
                            @else
                                <img src="{{ $item->file_path }}" alt="{{ $item->title }}" loading="lazy" class="projects-card__file size-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                            <span class="projects-card__type pointer-events-none absolute rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-widest text-default-900 shadow-sm">{{ $item->media_type }}</span>
                        </div>
                        <div class="projects-card__caption flex items-start gap-4 p-5 md:p-6">
                            <span class="mt-1 text-sm font-semibold text-primary">{{ str_pad((string) ($projectMedia->firstItem() + $loop->index), 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="min-w-0 text-xl font-semibold leading-snug text-default-900">{{ $item->title }}</h3>
                        </div>
                    </article>
                @empty
                <div class="projects-empty col-span-full rounded-2xl border border-dashed border-default-300 bg-default-100 px-6 py-20 text-center">
                        <p class="text-lg font-medium text-default-700">Project media will appear here soon.</p>
                    </div>
                @endforelse
            </div>
            @if ($projectMedia->hasPages())
                <nav class="projects-pagination" aria-label="Project gallery pages" data-project-pagination data-cms-ignore>
                    @if ($projectMedia->onFirstPage())
                        <span class="projects-pagination__disabled" aria-disabled="true">Previous</span>
                    @else
                        <a href="{{ $projectMedia->previousPageUrl() }}" rel="prev">Previous</a>
                    @endif
                    <span class="projects-pagination__current" aria-current="page">Page {{ $projectMedia->currentPage() }} of {{ $projectMedia->lastPage() }}</span>
                    @if ($projectMedia->hasMorePages())
                        <a href="{{ $projectMedia->nextPageUrl() }}" rel="next">Next</a>
                    @else
                        <span class="projects-pagination__disabled" aria-disabled="true">Next</span>
                    @endif
                </nav>
            @endif
        </div>
    </section>
@endsection
