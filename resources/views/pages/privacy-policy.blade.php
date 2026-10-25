@extends('layouts.app')

@section('title', 'Privacy Policy | HARIPRIYA')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/privacy-policy.css') }}?v={{ filemtime(public_path('css/privacy-policy.css')) }}">
@endpush

@section('content')
<section class="page-hero-header-clearance overflow-hidden relative size-full lg:py-50 py-25">
        <div class="container relative z-10">
            <div class="text-center mb-17.5">
                <h1 class="lg:text-7xl md:text-[56px] text-[48px] mb-4" data-cms-key="privacy-policy/title">{{ $privacyPolicyTitle }}</h1>
                <p data-cms-ignore>Last updated: {{ $privacyPolicyLastUpdated }}</p>
            </div>

            <div class="privacy-policy-content lg:w-200 mx-auto" @if ($privacyPolicyBody !== null) data-cms-ignore @else data-cms-editor-ignore @endif>
                @if ($privacyPolicyBody !== null)
                    {!! $privacyPolicyBody !!}
                @else
                    @include('pages.partials.privacy-policy-default')
                @endif
            </div>
        </div>

    </section>


    <!-- Footer -->
@endsection
