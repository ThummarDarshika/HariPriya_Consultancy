@extends('layouts.app')

@section('title', 'Services | HARIPRIYA')

@section('content')
<section class="page-hero-header-clearance overflow-hidden relative size-full lg:py-50 py-25 bg-default-100">
        <div class="container relative z-10">
            <div class="text-center mb-17.5">
                <h1 class="lg:text-7xl md:text-[56px] text-[48px]">Our Services</h1>
            </div>

            <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-5 mb-17.5" data-cms-collection="services">

                <!-- Service 1 -->
                <div class="bg-white p-5 group relative">
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/service-1-BZvdAoiD.png') }}" class="object-cover transition-all duration-500 group-hover:scale-110">
                    </div>
                    <h2 class="lg:text-[28px] text-2xl mb-4">Product assembly</h2>
                    <p>Complete product assembly services with quality testing and packaging solutions.</p>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-5 group relative">
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/service-2-G0HC8ZqU.png') }}" class="object-cover transition-all duration-500 group-hover:scale-110">
                    </div>
                    <h2 class="lg:text-[28px] text-2xl mb-4">Sheet metal fabrication</h2>
                    <p>Comprehensive sheet metal services including cutting, forming, welding, and finishing.</p>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-5 group relative">
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/service-3-z7zj_aHT.png') }}" class="object-cover transition-all duration-500 group-hover:scale-110">
                    </div>
                    <h2 class="lg:text-[28px] text-2xl mb-4">CNC machining services</h2>
                    <p>Precision CNC machining with 5-axis technology for complex, high-accuracy parts.</p>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-5 group relative">
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/service-4-Dy9kmUjG.png') }}" class="object-cover transition-all duration-500 group-hover:scale-110">
                    </div>
                    <h2 class="lg:text-[28px] text-2xl mb-4">Injection molding</h2>
                    <p>High-volume plastic injection molding with state-of-the-art equipment and quality control.</p>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-5 group relative">
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/service-5-CRYzLEos.png') }}" class="object-cover transition-all duration-500 group-hover:scale-110">
                    </div>
                    <h2 class="lg:text-[28px] text-2xl mb-4">Surface finishing</h2>
                    <p>Professional surface treatment and finishing services for enhanced durability and aesthetics.</p>
                </div>

                <!-- Service 6 -->
                <div class="bg-white p-5 group relative">
                    <div class="overflow-hidden rounded relative mb-4">
                        <img src="{{ asset('assets/service-6-AmczB5iX.png') }}" class="object-cover transition-all duration-500 group-hover:scale-110">
                    </div>
                    <h2 class="lg:text-[28px] text-2xl mb-4">Quality control &amp; testing</h2>
                    <p>Advanced inspection and testing to ensure every component meets strict quality standards.</p>
                </div>

            </div>


            <div class="lg:w-269 mx-auto bg-default-900 md:p-12 p-6 bg-no-repeat bg-cover rounded" style="background-image: url('{{ $siteAssets['cta.background'] }}')" data-cms-managed-asset>
                <div class="flex md:flex-row flex-col gap-6 items-center justify-between">
                    <h2 class="lg:text-4xl text-2xl text-white">Ready to start your <br>Next project?</h2>

                    <div>
                        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-950 transition-all">
                            <!-- TEXT -->
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Schedule Now
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Schedule Now
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
                </div>
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


    <!-- Footer -->
@endsection
