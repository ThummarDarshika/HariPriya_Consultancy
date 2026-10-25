@extends('layouts.app')

@section('title', $jobOpening->title.' | Careers | HARIPRIYA')
@section('meta_description', 'Apply for the '.$jobOpening->title.' role at HARIPRIYA.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/career.css') }}?v={{ filemtime(public_path('css/career.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/inner-page-banner.css') }}?v={{ filemtime(public_path('css/inner-page-banner.css')) }}">
@endpush

@section('content')
    <div class="career-page">
        <section class="career-detail-hero inner-page-banner"><div class="career-shell"><a class="career-back" href="{{ route('career.index') }}">← All open roles</a><p class="career-eyebrow" data-cms-ignore>{{ $jobOpening->department }}</p><h1 data-cms-ignore>{{ $jobOpening->title }}</h1><div class="career-detail-hero__meta" data-cms-ignore><span>{{ $jobOpening->location }}</span><span>{{ $jobOpening->employment_type }}</span></div><a class="career-hero__link" href="#apply" data-cms-editor-ignore>Apply for this role <span aria-hidden="true" data-cms-ignore>↗</span></a></div>@include('partials.inner-page-banner-effects')</section>
        <div class="career-shell career-detail-grid">
            <div class="career-description">
                <section><h2>About the role</h2><p data-cms-ignore>{{ $jobOpening->description }}</p></section>
                <section><h2>What you will do</h2><p data-cms-ignore>{{ $jobOpening->responsibilities }}</p></section>
                <section><h2>What we are looking for</h2><p data-cms-ignore>{{ $jobOpening->requirements }}</p></section>
            </div>
            <section class="career-application" id="apply">
                <p class="career-eyebrow">YOUR NEXT STEP</p><h2>Apply for this role</h2><p class="career-application__intro">Share your details and resume. Fields marked * are required.</p>
                @if (session('career_status'))<div class="career-success" role="status" data-cms-ignore>{{ session('career_status') }}</div>@endif
                @if ($errors->any())<div class="career-error-summary" role="alert" data-cms-ignore>Please correct the highlighted fields and try again.</div>@endif
                <form method="post" action="{{ route('career.apply', $jobOpening->slug) }}" enctype="multipart/form-data" data-career-form novalidate>
                    @csrf
                    <div class="career-form-grid">
                        <label class="career-field">Full name *<input name="full_name" type="text" value="{{ old('full_name') }}" maxlength="160" autocomplete="name" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="full_name">@error('full_name'){{ $message }}@enderror</span></label>
                        <label class="career-field">Email address *<input name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="email">@error('email'){{ $message }}@enderror</span></label>
                        <label class="career-field">Phone number *<input name="phone" type="tel" value="{{ old('phone') }}" maxlength="10" inputmode="numeric" pattern="[0-9]{10}" autocomplete="tel-national" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="phone">@error('phone'){{ $message }}@enderror</span></label>
                        <label class="career-field">Current location *<input name="location" type="text" value="{{ old('location') }}" maxlength="160" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="location">@error('location'){{ $message }}@enderror</span></label>
                        <label class="career-field">Highest qualification *<input name="qualification" type="text" value="{{ old('qualification') }}" maxlength="160" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="qualification">@error('qualification'){{ $message }}@enderror</span></label>
                        <label class="career-field">Experience (years) *<input name="experience_years" type="number" min="0" max="60" value="{{ old('experience_years') }}" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="experience_years">@error('experience_years'){{ $message }}@enderror</span></label>
                        <label class="career-field">Current company<input name="current_company" type="text" value="{{ old('current_company') }}" maxlength="160"><span class="career-field__error" data-cms-ignore data-career-error="current_company">@error('current_company'){{ $message }}@enderror</span></label>
                        <label class="career-field">Notice period<input name="notice_period" type="text" value="{{ old('notice_period') }}" maxlength="80"><span class="career-field__error" data-cms-ignore data-career-error="notice_period">@error('notice_period'){{ $message }}@enderror</span></label>
                        <label class="career-field career-field--wide">Why are you interested in this role? *<textarea name="cover_letter" rows="5" maxlength="5000" data-career-required>{{ old('cover_letter') }}</textarea><span class="career-field__error" data-cms-ignore data-career-error="cover_letter">@error('cover_letter'){{ $message }}@enderror</span></label>
                        <label class="career-field career-field--wide">Resume (PDF, DOC or DOCX; up to 5 MB) *<input name="resume" type="file" accept=".pdf,.doc,.docx" data-career-required><span class="career-field__error" data-cms-ignore data-career-error="resume">@error('resume'){{ $message }}@enderror</span></label>
                    </div>
                    <label class="career-consent"><input name="consent" type="checkbox" value="1" @checked(old('consent')) data-career-required><span>I agree to HARIPRIYA using my details to review this application. *</span></label><span class="career-field__error" data-cms-ignore data-career-error="consent">@error('consent'){{ $message }}@enderror</span>
                    <p class="career-submit-status" data-career-status data-cms-ignore role="status" aria-live="polite" hidden></p>
                    <button class="career-submit" type="submit" data-career-submit data-cms-editor-ignore>Submit application <span aria-hidden="true" data-cms-ignore>↗</span></button>
                </form>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/career-application.js') }}?v={{ filemtime(public_path('js/career-application.js')) }}"></script>
@endpush
