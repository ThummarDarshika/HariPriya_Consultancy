@extends('layouts.app')

@section('title', 'Blogs | Manufactt - Manufacturing Services Website TailwindCSS 4 Template')

@section('content')
<section class="overflow-hidden relative size-full lg:pt-40 py-25 bg-default-100">
        <div class="container relative z-10">
            <div class="text-center mb-17.5">
                <h1 class="lg:text-7xl md:text-[56px] text-[48px]">Our Blogs</h1>
            </div>
        </div>

        <div class="flex items-stretch md:justify-center justify-between xl:gap-80.5 lg:gap-75 md:gap-45 gap-0 absolute inset-0">
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
        </div>

        <div class="absolute inset-0 size-full bg-[url(../images/bg-noice.gif)] opacity-4 bg-auto bg-repeat bg-position-[50%] object-cover"></div>

    </section>

    <section class="lg:py-50 py-25">
        <div class="container relative z-10">
            <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-5 mb-17.5">
                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Sustainability
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2 class="mb-4">Sustainable manufacturing driving a greener future</h2>

                    <div class="overflow-hidden rounded relative">
                        <img src="{{ asset('assets/blog-5-tqSxhm9x.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">

                        <div class="absolute top-2.5 end-2.5">
                            <span class="bg-primary text-white rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                                Featured
                            </span>
                        </div>
                    </div>
                </div>


                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-8-i2IkvBct.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>

                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-6-BriHLuEI.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>

                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-4-C1Q1HbBk.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>

                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-2-OIc_O7mO.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>

                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-4-C1Q1HbBk.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>

                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-3-ClgGzUK2.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>

                <div class="bg-default-100 p-4 rounded group relative">
                    <a href="{{ route('blog-detail') }}" class="absolute inset-0 z-10"></a>
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/blog-1-D1EzCJZ9.png') }}" alt="" class="object-cover h-75 w-full transition-all duration-500 group-hover:scale-110">
                    </div>

                    <div class="flex items-center justify-between mb-2.5">
                        <span class="bg-white text-primary rounded py-1 px-2 text-sm inline-flex items-center justify-center">
                            Smart Manufacturing
                        </span>

                        <p class="text-sm">17 Oct 25</p>
                    </div>

                    <h2>Sustainable manufacturing driving a greener future</h2>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
@endsection
