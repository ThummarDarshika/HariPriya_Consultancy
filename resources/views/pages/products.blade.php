@extends('layouts.app')

@section('title', 'Products | HARIPRIYA')

@section('content')
<section class="page-hero-header-clearance overflow-hidden relative size-full lg:py-50 py-25 bg-default-100">
        <div class="container-full relative z-10">

            <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                <div class="size-2 bg-primary"></div>
                <div class="text-sm text-default-900">What We Build</div>
            </div>

            <div class="grid xl:grid-cols-2 items-center xl:gap-20 gap-12.5 mt-7.5">
                <div>
                    <h1 class="lg:text-[58px] md:text-[34px] text-[28px]">Innovative <span class="text-primary">products</span> across <br> all sectors</h1>
                </div>

                <div class="ms-auto">
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
            </div>

            <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-7.5 my-17.5" data-product-gallery data-cms-collection="products">

                <!-- Product 1 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Aluminum Gear Housing</h3>
                    <a href="{{ asset('assets/1-BtwCsebB.webp') }}">
                        <img src="{{ asset('assets/1-BtwCsebB.webp') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        Precision CNC machined aluminum housings for gear systems and machinery.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Aluminum 6061 / 7075</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">CNC Machining</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Custom dimensions up to 500mm</div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Custom Plastic Enclosures</h3>
                    <a href="{{ asset('assets/product-2-Cg8Cv16T.png') }}">
                        <img src="{{ asset('assets/product-2-Cg8Cv16T.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        Injection molded enclosures for electronics and telecom applications.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">ABS, Polycarbonate, Nylon</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">Injection Molding</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Varies – custom moldable</div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Electrical Control Panels</h3>
                    <a href="{{ asset('assets/product-3-fEweepR8.png') }}">
                        <img src="{{ asset('assets/product-3-fEweepR8.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        Weather-resistant control panels for industrial automation systems.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Mild Steel, Stainless Steel</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">Sheet Metal Fabrication &amp; Assembly</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Small to full-scale cabinets</div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Precision Shaft Assemblies</h3>
                    <a href="{{ asset('assets/product-4--sM7am50.png') }}">
                        <img src="{{ asset('assets/product-4--sM7am50.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        High-precision steel shafts for automotive and industrial equipment.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Alloy Steel, Stainless Steel</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">Turning &amp; Grinding</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Up to 1200mm</div>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Industrial Heat Sinks</h3>
                    <a href="{{ asset('assets/product-5-P23PaWCJ.png') }}">
                        <img src="{{ asset('assets/product-5-P23PaWCJ.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        High-efficiency aluminum heat sinks for advanced thermal management.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Aluminum Extrusion</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">CNC Machining</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Small to large profiles</div>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Metal Brackets &amp; Mounts</h3>
                    <a href="{{ asset('assets/product-6-DeViwF6-.png') }}">
                        <img src="{{ asset('assets/product-6-DeViwF6-.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        Custom-fabricated brackets and mounts for industrial installations.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Mild Steel, Aluminum</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">Laser Cutting &amp; Bending</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Custom fabricated</div>
                        </div>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Precision Machined Flanges</h3>
                    <a href="{{ asset('assets/product-7-CD6FizGZ.png') }}">
                        <img src="{{ asset('assets/product-7-CD6FizGZ.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        High-accuracy flanges for piping, valves, and mechanical systems.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Carbon Steel, Stainless Steel</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">CNC Turning</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Up to 800mm diameter</div>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                    <h3 class="text-2xl text-white mb-5">Sheet Metal Enclosures</h3>
                    <a href="{{ asset('assets/product-8-_qvs3v0W.png') }}">
                        <img src="{{ asset('assets/product-8-_qvs3v0W.png') }}" alt="" class="rounded-md mb-7.5">
                    </a>

                    <p class="mb-7.5 text-default-400">
                        Durable enclosures designed for electrical and industrial equipment.
                    </p>

                    <div class="divide-y divide-default-700 *:py-4 *:flex *:items-center *:justify-between">
                        <div>
                            <div class="text-default-400 text-sm">Material</div>
                            <div class="text-white text-sm">Mild Steel, Stainless Steel</div>
                        </div>
                        <div>
                            <div class="text-default-400 text-sm">Capability</div>
                            <div class="text-white text-sm">Sheet Metal Fabrication</div>
                        </div>
                        <div class="pb-0!">
                            <div class="text-default-400 text-sm">Size Range</div>
                            <div class="text-white text-sm">Small to large cabinets</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:w-269 mx-auto bg-default-900 md:p-12 p-6 bg-no-repeat bg-cover rounded" style="background-image: url('{{ $siteAssets['cta.background'] }}')" data-cms-managed-asset>
                <div class="flex lg:flex-row flex-col gap-10 lg:items-center justify-between">
                    <div>
                        <h2 class="lg:text-4xl text-2xl text-white">Custom Order Inquiry</h2>
                        <p class="text-white lg:w-140 mt-2.5">Looking for a product we don't offer yet? Send us your custom specifications and we will take it forward from there.</p>
                    </div>

                    <div class="grow lg:text-end">
                        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-950 transition-all">
                            <!-- TEXT -->
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Send Request
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Send Request
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
