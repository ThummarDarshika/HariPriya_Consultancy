@extends('layouts.app')

@section('title', 'About Us | HARIPRIYA')

@section('content')
<section class="overflow-hidden relative size-full lg:pt-50 pt-25 pb-12.5 bg-default-100">
        <div class="container-full relative z-10">

            <div class="text-center mb-29">
                <div class="mb-4 inline-flex items-center mx-auto gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                    <div class="size-2 bg-primary"></div>
                    <div class="text-sm text-default-900">What We Are</div>
                </div>

                <h1 class="lg:text-7xl md:text-[56px] text-[48px]">About us</h1>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex -space-x-4.5">
                        @foreach (range(1, 4) as $avatarNumber)
                            <img src="{{ $siteAssets['about.team_avatar_'.$avatarNumber] }}" alt="Team member {{ $avatarNumber }}" data-cms-managed-asset class="size-10 p-0.5 bg-white rounded-md">
                        @endforeach
                        <a href="{{ route('about') }}" class="size-10 p-0.5 bg-white rounded-md">
                            <div class="bg-default-900 text-white rounded flex items-center justify-center size-full">
                                10+
                            </div>
                        </a>
                    </div>
                    <p class="text-sm w-32.5">Team of passionate professionals</p>
                </div>
                <p class="text-sm text-default-900">21.0278° N, 105.8342° E</p>
            </div>
        </div>

        <div class="flex items-stretch md:justify-center justify-between xl:gap-80.5 lg:gap-75 md:gap-45 gap-0 absolute inset-0">
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-900 w-0.5 h-full opacity-7"></div>
        </div>

        <div class="absolute inset-0 size-full opacity-4 bg-auto bg-repeat bg-position-[50%] object-cover" style="background-image: url('{{ $siteAssets['about.hero_background'] ?? '/assets/bg-noice-CMKwJ6uj.gif' }}')" data-cms-managed-asset></div>

    </section>

    <section class="relative  overflow-hidden">
        <div class="grid lg:grid-cols-5 md:grid-cols-2">
            <div class="lg:col-span-3 lg:flex hidden">
                <img src="{{ asset('assets/hero-BK9Dnytd.webp') }}" alt="" class="lg:h-150 h-100 object-cover w-full">
            </div>

            <div class="lg:col-span-2">
                <div class="bg-primary flex flex-wrap flex-col h-full">
                    <div class="w-full py-12.5 px-7.5">
                        <p class="text-white">We are a team dedicated to precision engineering, delivering solutions that shape industries worldwide. Our journey is defined by trust, quality, and a commitment to excellence in every project.</p>

                        <div class="flex lg:flex-row flex-col lg:items-center items-start gap-7.5 mt-7.5">
                            <a href="{{ route('about') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-default-900 text-base font-medium text-white transition-all">
                                <!-- TEXT -->
                                <span class="py-3.75 ps-6">
                                    <span class="relative block overflow-hidden">
                                        <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            Meet Our Team
                                        </span>
                                        <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            Meet Our Team
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

                            <a href="{{ $siteAssets['brochure'] ?: '#' }}" download @if (! $siteAssets['brochure']) aria-disabled="true" onclick="return false" @endif class="text-default-900 underline transition-all hover:decoration-transparent flex items-center">
                                Download Brochure
                                <i class="iconify tabler--download size-6 ms-4"></i>
                            </a>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="relative z-10 md:flex hidden gap-5 flex-nowrap w-full overflow-hidden mt-auto" data-cms-ignore>
                            <ul class="infinite-scroll flex gap-5 justify-start items-center ">
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                            </ul>

                            <ul class="infinite-scroll flex gap-5 justify-start items-center ">
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                                <h2 class="uppercase text-nowrap text-white/30 lg:text-7xl md:text-[56px] text-[48px]">{{ $siteAssets['about.since_label'] }}</h2>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="overflow-hidden relative size-full lg:pt-50 py-25 bg-default-100">
        <div class="container relative z-10">

            <div class="grid lg:grid-cols-7 gap-17.5 mb-20">
                <div class="lg:col-span-2">
                    <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                        <div class="size-2 bg-primary"></div>
                        <div class="text-sm text-default-900">Our journey</div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <h2 class="lg:text-[58px] md:text-[34px] text-[28px]">Engineering trust and <span class="text-primary">quality</span> through years of manufacturing experience</h2>
                </div>
            </div>

            <div class="grid lg:grid-cols-4 md:grid-cols-3 lg:gap-17.5 gap-6 mb-20">
                <div class="lg:col-span-1">
                    <div class="relative overflow-hidden rounded-lg">
                        <img src="{{ $founder['image'] }}" alt="Founder portrait" data-cms-shared-key="global/founder/image" class="w-full object-cover" style="aspect-ratio: 282 / 270">
                        <div class="absolute inset-0 bg-linear-to-b from-transparent to-default-900 size-full flex flex-col items-center justify-end">
                            <h3 class="text-xl text-white mb-2.5" data-cms-shared-key="global/founder/name">{{ $founder['name'] }}</h3>
                            <p class="mb-4" data-cms-shared-key="global/founder/role">{{ $founder['role'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 md:col-span-2">
                    <div class="grid lg:grid-cols-2 md:gap-17.5 gap-6">
                        <div>
                            <h3 class="lg:text-[28px] text-2xl mb-7.5">Our story</h3>

                            <p class="mb-3">We started with a vision to redefine manufacturing standards and provide solutions that industries can rely on. Over the years, we have grown into a team of skilled professionals equipped with cutting-edge technology, serving clients across diverse sectors and geographies.</p>

                            <p>What drives us is not just producing components, but delivering value — ensuring every part we manufacture contributes to our client's success. Our commitment to quality, timely delivery, and innovation has helped us establish long-term partnerships with leading businesses worldwide</p>
                        </div>

                        <div>
                            <h3 class="lg:text-[28px] text-2xl mb-7.5">Our capabilities</h3>

                            <div class="border-b border-default-300 py-4 transition-all duration-500 hover:border-default-600">
                                <a href="{{ route('about') }}" class="flex items-center justify-between">
                                    <div>Product Design</div>
                                    <i class="iconify tabler--arrow-narrow-right size-6 text-primary"></i>
                                </a>
                            </div>
                            <div class="border-b border-default-300 py-4 transition-all duration-500 hover:border-default-600">
                                <a href="{{ route('about') }}" class="flex items-center justify-between">
                                    <div>Product assembly</div>
                                    <i class="iconify tabler--arrow-narrow-right size-6 text-primary"></i>
                                </a>
                            </div>
                            <div class="border-b border-default-300 py-4 transition-all duration-500 hover:border-default-600">
                                <a href="{{ route('about') }}" class="flex items-center justify-between">
                                    <div>Product Testing</div>
                                    <i class="iconify tabler--arrow-narrow-right size-6 text-primary"></i>
                                </a>
                            </div>
                            <div class="border-b border-default-300 py-4 transition-all duration-500 hover:border-default-600 mb-6">
                                <a href="{{ route('about') }}" class="flex items-center justify-between">
                                    <div>Product QA</div>
                                    <i class="iconify tabler--arrow-narrow-right size-6 text-primary"></i>
                                </a>
                            </div>

                            <a href="{{ route('services') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-default-900 text-base font-medium text-white transition-all">
                                <!-- TEXT -->
                                <span class="py-3.75 ps-6">
                                    <span class="relative block overflow-hidden">
                                        <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            View all Capabilities
                                        </span>
                                        <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            View all Capabilities
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

    <section class="overflow-hidden relative size-full lg:pt-50 py-25">
        <div class="container relative z-10">

            <div class="text-center mb-10">
                <div class="mb-4 inline-flex items-center mx-auto gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                    <div class="size-2 bg-primary"></div>
                    <div class="text-sm text-default-900">What We Are</div>
                </div>

                <h2 class="lg:text-7xl md:text-[56px] text-[48px]">Trusted by <span class="text-primary">industry</span> leaders</h2>
            </div>

            <div class="grid lg:grid-cols-6 md:grid-cols-4 grid-cols-2 lg:gap-7.5 gap-4" data-cms-ignore>
                @foreach ($companies as $company)
                    <div class="bg-default-100 rounded-md lg:h-32.5 h-25 w-full flex items-center justify-center px-5">
                        <img src="{{ $company->image_path }}" alt="{{ $company->name }}">
                    </div>
                @endforeach
            </div>

            <hr class="lg:my-12.5 my-10 border-default-300">

            <div class="flex items-center flex-wrap gap-5">
                <div class="lg:w-[40%] w-full">
                    <h3 class="lg:text-[28px] text-2xl"><span class="text-primary">20 Years</span> of manufacturing excellence &amp; recognition</h3>
                </div>

                <div class="lg:w-[60%] w-full">
                    <div class="flex items-start md:justify-end justify-center gap-7.5" data-cms-ignore>
                        @foreach ($certificates as $certificate)
                            <img src="{{ $certificate->image_path }}" alt="{{ $certificate->name }}" class="lg:w-24 md:w-20 w-15 h-auto">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden">
        <div class="overflow-hidden h-200 w-full relative">
            <video id="myVideo" loop="" autoplay="" muted="" class="bg-[url('../images/other/about-video-bg.jpg')] object-cover bg-cover bg-position-[50%] flex w-full h-full absolute -inset-full m-auto -z-10">
                <source src="{{ asset('assets/about-video-hkpZ2gMR.mp4') }}" type="video/mp4" class="object-bottom">
                <source src="{{ asset('assets/about-video-CNYeEx3X.webm') }}" type="video/webm" class="object-bottom">
            </video>

            <div class="absolute end-10 bottom-10 z-100">
                <button id="toggleBtn" class="size-10 flex items-center justify-center bg-primary text-white rounded-full">
                    <i class="iconify tabler--player-play-filled size-4 hidden" id="playIcon"></i>
                    <i class="iconify tabler--player-pause-filled size-4" id="pauseIcon"></i>
                </button>
            </div>
        </div>

        <div class="absolute inset-0 bg-default-950/50 z-80 lg:py-50 py-25">
            <div class="container">
                <div class="h-100 flex flex-col justify-between">
                    <div class="flex gap-5">
                        <div class="w-px min-h-full bg-primary block"></div>
                        <h3 class="text-white text-2xl md:text-4xl lg:text-[42px] w-165">Delivering quality across industries and borders.</h3>
                    </div>

                    <div class="text-end">
                        <h3 class="text-white text-2xl md:text-4xl lg:text-[42px]">50,000 <span class="text-primary">+</span></h3>
                        <p class="text-white">Global delivery. Precision assured</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="team-section" class="overflow-hidden relative size-full lg:py-50 md:py-25 py-12.5 bg-default-100">
        <div class="container relative z-10">

            <div class="mb-10">
                <div class="mb-4 inline-flex items-center mx-auto gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                    <div class="size-2 bg-primary"></div>
                    <div class="text-sm text-default-900">Meet our experts</div>
                </div>

                <h1 class="lg:text-[58px] md:text-[52px] text-[42px]">Leaders in <span class="text-primary">precision</span> Work</h1>
            </div>

            <div class="grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-7.5" data-cms-collection="team-members">
                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/1-BvH2oRHB.webp') }}" alt="" class="rounded-lg">
                    <h3 class="lg:text-[28px] text-xl">James anderson</h3>
                    <div class="team-job-title">Head of operations</div>
                    <div class="flex text-default-900 gap-4">
                        <a href="https://www.instagram.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-instagram size-5"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-linkedin-filled size-5"></i>
                        </a>
                        <a href="https://x.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-x size-5"></i>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/2-CnyzFw4R.webp') }}" alt="" class="rounded-lg">
                    <h3 class="lg:text-[28px] text-xl">James anderson</h3>
                    <div class="team-job-title">Head of operations</div>
                    <div class="flex text-default-900 gap-4">
                        <a href="https://www.instagram.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-instagram size-5"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-linkedin-filled size-5"></i>
                        </a>
                        <a href="https://x.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-x size-5"></i>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/3-CovcYcz-2wc7bx.webp') }}" alt="" class="rounded-lg">
                    <h3 class="lg:text-[28px] text-xl">James anderson</h3>
                    <div class="team-job-title">Head of operations</div>
                    <div class="flex text-default-900 gap-4">
                        <a href="https://www.instagram.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-instagram size-5"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-linkedin-filled size-5"></i>
                        </a>
                        <a href="https://x.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-x size-5"></i>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/4-DClr7GQJ.webp') }}" alt="" class="rounded-lg">
                    <h3 class="lg:text-[28px] text-xl">James anderson</h3>
                    <div class="team-job-title">Head of operations</div>
                    <div class="flex text-default-900 gap-4">
                        <a href="https://www.instagram.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-instagram size-5"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-linkedin-filled size-5"></i>
                        </a>
                        <a href="https://x.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-x size-5"></i>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/5-BGS94RRO.webp') }}" alt="" class="rounded-lg">
                    <h3 class="lg:text-[28px] text-xl">James anderson</h3>
                    <div class="team-job-title">Head of operations</div>
                    <div class="flex text-default-900 gap-4">
                        <a href="https://www.instagram.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-instagram size-5"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-linkedin-filled size-5"></i>
                        </a>
                        <a href="https://x.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-x size-5"></i>
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <img src="{{ asset('assets/6-v477bqBM.webp') }}" alt="" class="rounded-lg">
                    <h3 class="lg:text-[28px] text-xl">James anderson</h3>
                    <div class="team-job-title">Head of operations</div>
                    <div class="flex text-default-900 gap-4">
                        <a href="https://www.instagram.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-instagram size-5"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-linkedin-filled size-5"></i>
                        </a>
                        <a href="https://x.com/" target="_blank" class="social-link w-inline-block">
                            <i class="iconify tabler--brand-x size-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Footer -->
@endsection
