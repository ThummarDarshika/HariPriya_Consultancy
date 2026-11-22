<div class="flex flex-col md:flex-row gap-7.5" data-client-reviews data-cms-collection="testimonials" data-cms-server-rendered data-cms-ignore>
    <div class="client-review-rail min-w-26 p-5 flex items-center justify-center rounded-md bg-default-950">
        <nav class="client-review-tabs flex md:flex-col flex-row flex-wrap justify-center gap-4" role="tablist" aria-label="Client reviews" aria-orientation="vertical">
            @foreach ($clientReviews as $review)
                <button type="button" class="client-review-tab border-3 border-transparent opacity-55 transition-all rounded-full {{ $loop->first ? 'active' : '' }}" id="client-review-tab-{{ $review->id }}" aria-controls="client-review-panel-{{ $review->id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->first ? '0' : '-1' }}" role="tab" aria-label="Review by {{ $review->client_name ?: $review->title }}">
                    @include('pages.partials.client-portrait', ['portraitClass' => 'size-15 rounded-full'])
                </button>
            @endforeach
        </nav>
    </div>
    <div class="client-review-content w-full rounded-md bg-default-100 p-10">
        @foreach ($clientReviews as $review)
            <div id="client-review-panel-{{ $review->id }}" class="h-full" role="tabpanel" aria-labelledby="client-review-tab-{{ $review->id }}" tabindex="0" @unless ($loop->first) hidden @endunless>
                <div class="flex h-full flex-col">
                    <div class="mb-5 flex gap-1.5" role="img" aria-label="{{ $review->rating ?? 5 }} out of 5 stars">
                        @foreach (range(1, 5) as $star)
                            <i aria-hidden="true" class="iconify tabler--star-filled size-5 text-primary {{ $star > ($review->rating ?? 5) ? 'client-review-star--empty' : '' }}"></i>
                        @endforeach
                    </div>
                    <p class="text-default-900">{!! \Illuminate\Support\Str::of($review->description ?? '')->inlineMarkdown(['html_input' => 'strip', 'allow_unsafe_links' => false, 'max_nesting_level' => 100, 'max_delimiters_per_line' => 1000]) !!}</p>
                    <div class="mt-auto">
                        <h3 class="text-2xl lg:text-[28px] mb-2.5">{{ $review->client_name ?: $review->title }}</h3>
                        <div class="text-sm text-default-600">{{ $review->designation }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
