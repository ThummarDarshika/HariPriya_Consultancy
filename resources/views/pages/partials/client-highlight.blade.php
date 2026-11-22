@if ($clientReviews->isNotEmpty())
    <div class="flex flex-wrap items-center gap-3" data-client-highlight data-cms-ignore>
        <div class="flex -space-x-4.5">
            @foreach ($clientReviews->take(4) as $review)
                @include('pages.partials.client-portrait', ['portraitClass' => 'size-12.5 p-0.5 bg-white rounded-md'])
            @endforeach
        </div>
        <div>
            <div class="flex gap-1.5 mb-2" role="img" aria-label="{{ number_format($clientAverageRating, 1) }} out of 5 stars from {{ $clientReviews->count() }} client reviews">
                @foreach (range(1, 5) as $star)
                    <i aria-hidden="true" class="iconify tabler--star-filled flex size-4 text-white {{ $star > round($clientAverageRating) ? 'client-review-star--empty' : '' }}"></i>
                @endforeach
            </div>
            <p class="text-sm text-default-200">Happy clients worldwide</p>
        </div>
    </div>
@endif
