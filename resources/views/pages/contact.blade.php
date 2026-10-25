@extends('layouts.app')

@section('title', 'Contact Us | HARIPRIYA')

@section('content')
<section class="overflow-hidden relative size-full pt-50 bg-default-100">
        <div class="container-full relative z-10">
            <div class="grid xl:grid-cols-2 items-start xl:gap-25 gap-12.5 mb-32.5">
                <div class="lg:w-152 h-full flex flex-col">

                    <h1 class="lg:text-7xl md:text-[56px] text-[48px] mb-7.5">We're <span class="text-primary">ready</span> to <br> listen</h1>

                    <p class="mb-7.5">
                        Got questions or need assistance? Reach out to us anytime — our team is ready to provide the support and guidance you need.
                    </p>

                    <div>
                        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-default-900 text-base font-medium text-white transition-all">
                            <!-- TEXT -->
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Contact Now
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Contact Now
                                    </span>
                                </span>
                            </span>

                            <!-- ICON -->
                            <span class="m-1.25 flex size-10 items-center justify-center rounded rounded-ee-xl bg-primary text-white">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:translate-x-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        <i class="iconify tabler--arrow-narrow-right flex size-6"></i>
                                    </span>
                                    <span class="absolute top-0 end-7 group-hover:end-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        <i class="iconify tabler--arrow-narrow-right flex size-6"></i>
                                    </span>
                                </span>
                            </span>
                        </a>
                    </div>

                    <div class="flex lg:gap-20 gap-10 mt-auto pt-10">
                        <div>
                            <div class="text-primary mb-5">// Contact us on //</div>

                            <div class="flex flex-col gap-2">
                                <a href="tel:+(558)845889" class="underline decoration-transparent transition-all duration-300 hover:decoration-default-600">+(558) 845 889</a>
                                <a href="tel:+(41)845889568" class="underline decoration-transparent transition-all duration-300 hover:decoration-default-600">+(41) 845 889 568</a>
                                <a href="mailto:example@gmail.com" class="underline decoration-transparent transition-all duration-300 hover:decoration-default-600">example@gmail.com</a>
                            </div>
                        </div>

                        <div>
                            <div class="text-primary mb-5">// Find us //</div>

                            <div class="flex flex-col gap-2">
                                <p>USA - 123 creative street, suite 456, new york, NY 10001</p>
                                <p>USA - 93 back street, suite 786, new york, ny 10005</p>
                            </div>
                        </div>
                    </div>

                </div>

                <form method="post" action="{{ route('contact.submit') }}" data-contact-form class="p-7.5 bg-linear-to-br from-black via-black to-primary rounded-lg">
                    @csrf
                    @if (session('contact_status')) <p role="status" class="mb-5 text-white" data-cms-ignore>{{ session('contact_status') }}</p> @endif
                    @if ($errors->any()) <p role="alert" class="mb-5 text-white" data-cms-ignore>{{ $errors->first() }}</p> @endif

                    <div class="grid md:grid-cols-2 gap-7.5">
                        <div>
                            <label for="First-Name" class="text-default-300 block mb-2.5">First name *</label>
                            <input class="w-full bg-default-900 h-12.5 inline-flex border-default-700 rounded text-white" maxlength="128" name="first_name" type="text" id="First-Name" value="{{ old('first_name') }}" required>
                        </div>

                        <div>
                            <label for="Last-Name" class="text-default-300 block mb-2.5">Last name *</label>
                            <input class="w-full bg-default-900 h-12.5 inline-flex border-default-700 rounded text-white" maxlength="128" name="last_name" type="text" id="Last-Name" value="{{ old('last_name') }}" required>
                        </div>

                        <div>
                            <label for="email-address" class="text-default-300 block mb-2.5">Email address *</label>
                            <input class="w-full bg-default-900 h-12.5 inline-flex border-default-700 rounded text-white" maxlength="255" name="email" type="email" id="email-address" value="{{ old('email') }}" required>
                        </div>

                        <div>
                            <label for="phone-number" class="text-default-300 block mb-2.5">Phone number *</label>
                            <input class="w-full bg-default-900 h-12.5 inline-flex border-default-700 rounded text-white" maxlength="10" name="phone" type="tel" inputmode="numeric" pattern="[0-9]{10}" id="phone-number" value="{{ old('phone') }}" aria-required="true" autocomplete="tel-national" required>
                        </div>

                        <div class="md:col-span-2">
                            <label for="subject" class="text-default-300 block mb-2.5">Subject</label>
                            <input class="w-full bg-default-900 h-12.5 inline-flex border-default-700 rounded text-white" maxlength="255" name="subject" type="text" id="subject" value="{{ old('subject') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label for="message" class="text-default-300 block mb-2.5">Message *</label>
                            <textarea class="w-full bg-default-900 inline-flex border-default-700 rounded text-white" rows="5" maxlength="5000" name="message" id="message" required>{{ old('message') }}</textarea>
                        </div>

                        <div>
                            <button type="submit" data-contact-submit-button class="inline-flex py-3.75 px-6 items-center gap-3 text-default-900 rounded rounded-ee-2xl bg-white transition-all text-base font-medium">
                                <span data-contact-submit-label>Submit</span>
                                <span data-contact-submit-spinner class="contact-form-spinner" hidden aria-hidden="true"></span>
                            </button>
                            <p data-contact-form-progress role="status" aria-live="polite" class="mt-3 text-white" hidden></p>
                        </div>
                    </div>


                </form>
            </div>
        </div>

        <div class="relative z-10 flex gap-5 flex-nowrap w-full overflow-hidden mb-12.5" data-cms-ignore>
            @if ($companies->isNotEmpty())
                @foreach (range(1, 2) as $repeat)
                    <ul class="infinite-scroll-inverse flex gap-5 justify-start items-center [&amp;&gt;li]:flex [&amp;&gt;li]:items-center [&amp;&gt;li]:justify-center [&amp;&gt;li]:bg-white [&amp;&gt;li]:rounded [&amp;&gt;li]:w-57 [&amp;&gt;li]:h-39 [&amp;&gt;li]:mx-auto [&amp;&gt;li&gt;img]:w-25">
                        @foreach ($companies as $company)
                            <li><img src="{{ $company->image_path }}" alt="{{ $company->name }}"></li>
                        @endforeach
                    </ul>
                @endforeach
            @endif
        </div>

        <div class="flex items-stretch md:justify-center justify-between xl:gap-80.5 lg:gap-75 md:gap-45 gap-0 absolute inset-0">
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
        </div>

        <div class="absolute inset-0 size-full bg-[url(../images/bg-noice.gif)] opacity-4 bg-auto bg-repeat bg-position-[50%] object-cover" data-cms-ignore></div>

    </section>

    <!-- Footer -->
    <div data-contact-form-toast class="contact-form-toast" role="status" aria-live="polite" hidden></div>
@endsection

@unless (isset($cmsEditorPage))
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/contact-form.css') }}?v={{ filemtime(public_path('css/contact-form.css')) }}">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="{{ asset('js/contact-form.js') }}?v={{ filemtime(public_path('js/contact-form.js')) }}"></script>
    @endpush
@endunless
