@extends('layouts.app')

@section('title', 'Careers | HARIPRIYA')
@section('meta_description', 'Explore current career opportunities at HARIPRIYA.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/career.css') }}?v={{ filemtime(public_path('css/career.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/inner-page-banner.css') }}?v={{ filemtime(public_path('css/inner-page-banner.css')) }}">
@endpush

@section('content')
    <div class="career-page">
        <section class="career-hero inner-page-banner">
            <div class="career-shell">
                <p class="career-eyebrow">CAREERS AT HARIPRIYA</p>
                <h1>Build what comes next.</h1>
                <p>Explore current opportunities and find a role where your work can make an impact.</p>
                <a class="career-hero__link" href="#openings" data-cms-editor-ignore>Explore open roles <span aria-hidden="true" data-cms-ignore>↗</span></a>
            </div>
            @include('partials.inner-page-banner-effects')
        </section>

        <section class="career-shell career-openings" id="openings">
            <div class="career-section-heading"><div><p class="career-eyebrow">OPPORTUNITIES</p><h2>Open positions</h2></div><span data-cms-ignore>{{ $openings->count() }} {{ $openings->count() === 1 ? 'role' : 'roles' }}</span></div>
            @if ($openings->isNotEmpty())
                <div data-cms-collection="job-openings">
                    @foreach ($openings as $opening)
                        <a class="career-role" href="{{ route('career.show', $opening->slug) }}">
                            <div class="career-role__main"><span class="career-role__department">{{ $opening->department }}</span><h3>{{ $opening->title }}</h3><div class="career-role__meta"><span>{{ $opening->location }}</span><span>{{ $opening->employment_type }}</span></div></div>
                            <span class="career-role__arrow" aria-hidden="true">↗</span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="career-empty"><h3>No open positions right now</h3><p>Please check this page again for future opportunities.</p></div>
            @endif
        </section>
    </div>
@endsection
