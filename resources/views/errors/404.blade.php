@extends('layouts.app')

@section('title', '404 | Manufactt - Manufacturing Services Website TailwindCSS 4 Template')

@section('content')
<section class="relative bg-default-100 lg:py-50 py-25">
        <div class="container">
            <div class="relative z-10 bg-white w-150 mx-auto border border-default-300 rounded-lg">
                <div class="lg:p-15 p-8 text-center flex flex-col gap-5">
                    <h2 class="lg:text-7xl md:text-[56px] text-[48px]">404</h2>

                    <h3 class="lg:text-[40px] text-[26px]">Page not found</h3>

                    <p class="text-base text-default-600 mb-7.5">The page you are looking for doesn't exist or has been moved.</p>

                    <div class="flex justify-center">

                        <a href="{{ route('home') }}" class="group inline-flex items-center gap-5 rounded rounded-es-2xl bg-primary text-base font-medium text-white transition-all">
                            <!-- ICON -->
                            <span class="m-1.25 flex size-10 items-center justify-center rounded rounded-es-xl bg-default-900 text-white">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-x-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        <i class="iconify tabler--arrow-narrow-left flex size-6"></i>
                                    </span>
                                    <span class="absolute top-0 start-7 group-hover:start-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        <i class="iconify tabler--arrow-narrow-left flex size-6"></i>
                                    </span>
                                </span>
                            </span>

                            <!-- TEXT -->
                            <span class="py-3.75 pe-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Back to Home
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Back to Home
                                    </span>
                                </span>
                            </span>


                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
@endsection
