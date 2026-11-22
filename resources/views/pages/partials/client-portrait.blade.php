@if ($review->image)
    <img src="{{ $review->image }}" alt="{{ $review->client_name ?: $review->title }}" class="{{ $portraitClass }}">
@else
    <svg viewBox="0 0 24 24" fill="none" role="img" aria-label="{{ $review->client_name ?: $review->title }}" class="client-portrait-fallback {{ $portraitClass }}"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M4 22v-3a8 8 0 0 1 16 0v3" stroke="currentColor" stroke-width="1.5"/></svg>
@endif
