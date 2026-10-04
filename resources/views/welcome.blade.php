@extends('layouts.app')

@section('title', 'Manufactt - Tailwind CSS 4 Template | Manufactt - Manufacturing Services Website TailwindCSS 4 Template')

@section('content')
<!-- Hero Section -->
    <section class="overflow-hidden relative size-full lg:pt-50 pt-35">
        <div class="container-full relative z-10">
            <div class="grid xl:grid-cols-4 items-center xl:gap-20 gap-12.5 mb-32.5">
                <div class="xl:col-span-3">
                    <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                        <div class="size-2 bg-primary"></div>
                        <div class="text-sm text-default-900">Trusted manufacturing partner</div>
                    </div>

                    <h1 class="font-bold lg:text-7xl md:text-[56px] text-[48px] mt-4">From raw <span class="text-primary">material</span> <br> to market-ready</h1>
                </div>

                <div>
                    <div>
                        <div class="text-sm text-default-900 mb-2.5">// SINCE - 2005 //</div>
                        <p class="mb-7.5">From concept to production, we deliver high-quality, scalable, and cost-effective solutions tailored to your business needs.</p>

                        <a href="{{ route('services') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-default-900 text-base font-medium text-white transition-all">
                            <!-- TEXT -->
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Explore Our Capabilities
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Explore Our Capabilities
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

            <div class="flex justify-between mb-10">
                <div class="text-sm text-default-900">Based in: Los Angeles, USA</div>
                <a href="{{ route('home') }}" class="text-center uppercase text-sm transition-colors hover:text-primary">Scroll Down</a>
                <div class="text-sm text-default-900">21.0278° N, 105.8342° E</div>
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


    <!-- About / Who We Are Section -->
    <section class="relative overflow-hidden">
        <div class="overflow-hidden lg:h-275 h-250 w-full relative">
            <video id="myVideo" loop="" autoplay="" muted="" class="bg-[url('../images/other/video-bg.jpg')] object-cover bg-cover bg-position-[50%] flex w-full h-full absolute -inset-full m-auto -z-10">
                <source src="https://unifato.com/manufactt/assets/video-JGTIV9SH.mp4" type="video/mp4" class="object-bottom">
                <source src="https://unifato.com/manufactt/assets/video-Cu_LDHlO.webm" type="video/webm" class="object-bottom">
            </video>

            <div class="absolute end-10 bottom-10 z-100">
                <button id="toggleBtn" class="size-10 flex items-center justify-center bg-default-900 text-white rounded-full">
                    <i class="iconify tabler--player-play-filled size-4 hidden" id="playIcon"></i>
                    <i class="iconify tabler--player-pause-filled size-4" id="pauseIcon"></i>
                </button>
            </div>
        </div>

        <div class="absolute inset-0 flex items-end justify-center z-100 mb-25">
            <div>
                <div class="mx-auto w-60 p-2.5 rounded border border-white/10 bg-default-900/20 mb-5">
                    <img src="{{ asset('assets/a-quote-CBJAnhu7.webp') }}" alt="Hero Quote Image" class="mb-4 size-full rounded">

                    <div class="text-center">
                        <div class="text-white mb-1">Michael R. Bennett</div>
                        <div class="text-default-400 text-base">Founder &amp; CEO</div>
                    </div>
                </div>

                <p class="text-white text-center w-97">Great manufacturing isn't just about precision it's about vision, commitment, and the relentless pursuit of excellence.</p>
            </div>
        </div>

        <div class="-mb-12.5 bg-[linear-gradient(180deg,var(--color-default-900)_25%,var(--color-primary))] z-10 h-100 absolute bottom-0 inset-x-0 filter-[blur(40px)]"></div>
    </section>

    <!-- Capabilities / What We Do Section -->
    <section class="relative size-full bg-default-100 lg:py-50 md:py-25 py-20">
        <div class="container relative z-10">
            <div class="grid xl:grid-cols-3 items-center gap-8 mb-32.5">
                <div>
                    <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                        <div class="size-2 bg-primary"></div>
                        <div class="text-sm text-default-900">Who we are</div>
                    </div>

                    <div class="mt-7.5 mb-2.5 flex -space-x-4.5">
                        <img src="data:image/png;base64,UklGRvgEAABXRUJQVlA4IOwEAAAQFgCdASo8ADwAPm0qkkYkIiGhLB1bMIANiUAW/WmBAZNty7/TuW7koFA0uzC99hpRFNO+89NI3TE47fROzqfUvsE/rh6YHrr/dL2QP2qY61FneV6fMfWPlezGbZiB0+lzVYFtrS8AwD59flEhSW88UH63WoaxXecfchPUdKE7nq2+JtLqXa5q5tEt/7kyDszW1n+WQV/bPlERGukgZL5GmLX7K6QZzAUdtxu0FrnmOXbWK1CK+vpZwAD++uvuuFQmpRxdzgKhNSdF+ytS9fAJgWajWIchthWEUGRB7zHndumfzSnAqDCL8BL1qB1w/HUWJXp5pIQ5MADUpSJvlUYLeOvKwtwRDjuK11EocbYXsHo/ZRtt8xoKBJnmUlZ6HpIq3Op0t9NfR7rbe01VbcU4zMHp6579oxQhaUE+fu9Pdv6bQQWWXP4RUxIGscmvmoG90e1hcwNPfp+6dW8OLkCon8PtRqAQy21dGvXy8QpqOzAcd4TznjaOrZYikRwkPnk9EOMVwd1eo80fMzjC7IH3NrRRHWEm/K8jMK1SH5HrHJr0Xq/zP23Mxb0uZ1QEq/JvF2rdSDmZK9m7JCM8ZLiXh3YzL7wkUzCyPaDr66WX/VQW3ID7ZWs8hek+DdE+PYbRS93tP31XWwYq8dYlKRzVChsWv38WamqzUcTKXZ5mqvcYf3zqOxkG3y8DD3EWgO8kmEFOQ//ya2TgA/MPb45tdagQYHqmWb8sbMSuyr37Q9svMfuQa928JagojZmlo1sU0iXMBYSeqOxovgbVXdi7O/IcZlrsVESGBJWc/kv/UlsTkH0dQa13IDfMUQ1uo8/HvcXH1PXq4GVyId1fBr+xMubep8o0358l3TXmXtUrjXOlAlfnZEHUMJnRB4fxuLp4or0qgNY06ouyGIBXXwuhIK/Bl58lgqAKj/xL0sJ53yxLuh9AegwsiQ/VOP7A3CoZzN8MTEH85j/k+9/w1hb1NUk/c+tuXDA3uHDR2D/2EDx2X+YimjrXHOaK+i2z23qSGvUfwhexkDLOdyNv+qGvbNTvhG15zRY14XcI2uas2PO6NJWnaWe5iLKkdEAS5FDaqrzX2zLwNGMKaay9xyEyhkV7nBXdyTWRMgJrp89MQnywq7ifPErmvGLjQXPVh8Hp/aFLpCPXuZhwClE2nmktsxuSjm+IGQVBWqfni/89VX3neg0gzs1Y/+8seo4ppYwpnxKac5d+5P+rehWG0abSuUZ7ymljpDRQ9D/W0bh6K9M0K/l4ZbHGSgKsuzZNthBU5/Vag8WpqgKzmSKplFBqKo3pIZgBUOtolLNvlmCV2hoOwE7oF9hal09eJ4eJokYa5XX55jAjzxp8qp9CNqeH00CShrDWi238Kjkk4m9oUQQXl0zZ6Tj/CiiRZHGZz5nZodk2QgPmr0cylV+1xQyzpfU0ibIaHOZ1PF7E5KE7Ivs1/dj5V/J55/Xt8cCpK0xj1hoSXQxFSiLNV2A5IRiBj0wu5/GDF/0jOl9uxbsT4PIQDSxCpMggYh5S46qP/Z2lf4McVEWMatpmW7Xs3nn+MKFxr8mil+9SxEeX96K39dYFvGTgF5XW5lPJ+BqUtzIoG990uw0wOI/iJ2kvU86nMhn2RssA3s/i5t+zuDGSKfs1A9wh3qz/we6ntBF1e0UONetlUuEJOmgAAAA=" alt="avatar-1" class="size-14 p-0.5 bg-white rounded-md">
                        <img src="{{ asset('assets/avatar-3-C3tMRDPM.png') }}" alt="avatar-1" class="size-14 p-0.5 bg-white rounded-md">
                        <img src="{{ asset('assets/avatar-4-UUYBlZFU.png') }}" alt="avatar-1" class="size-14 p-0.5 bg-white rounded-md">
                        <img src="{{ asset('assets/avatar-1-BctzwD-q.png') }}" alt="avatar-1" class="size-14 p-0.5 bg-white rounded-md">
                        <div class="size-14 p-0.5 bg-white rounded-md">
                            <div class="bg-default-900 text-white rounded flex items-center justify-center size-full">
                                10+
                            </div>
                        </div>
                    </div>

                    <div class="text-sm">Team Of passionate<br>professionals</div>
                </div>

                <div class="xl:col-span-2">
                    <div>
                        <h2 class="lg:text-[58px] md:text-[34px] text-[28px]/[1.1] text-default-900 mb-7.5">Driven by technology, backed by experience, focused on
                            <span class="text-primary">manufacturing</span>
                            excellence
                        </h2>

                        <p class="mb-7.5">Backed by advanced technology, skilled craftsmanship, and a commitment to quality, we help businesses bring their ideas to life with confidence and speed. Whether it's prototyping or full-scale production, we're your trusted partner every step of the way.</p>

                        <div class="flex flex-wrap items-center lg:gap-7.5 gap-4">
                            <a href="{{ route('about') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-default-900 text-base font-medium text-white transition-all">
                                <!-- TEXT -->
                                <span class="py-3.75 ps-6">
                                    <span class="relative block overflow-hidden">
                                        <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            Learn More About Us
                                        </span>
                                        <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            Learn More About Us
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

                            <a href="{{ route('home') }}" target="_blank" class="text-primary underline transition-all hover:decoration-transparent flex items-center">
                                Download Brochure
                                <i class="iconify tabler--download size-6 ms-4"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container-full relative z-10">
            <div class="flex flex-wrap justify-center">
                <div class="bg-white border border-default-300 rounded-full lg:size-112 size-72 flex flex-col items-center justify-center text-center lg:pt-30 pt-14 overflow-hidden">
                    <div class="text-primary lg:mb-7.5 mb-5">// 2005-2K25 //</div>

                    <div data-target="20" class="text-4xl text-default-900 font-bold">20+</div>

                    <p class="text-base lg:w-75 w-57">Delivering consistent manufacturing excellence since day one.</p>

                    <img src="{{ asset('assets/group-QKyBjjGo.png') }}" alt="" class="lg:h-36.5 h-17.5 mt-auto">
                </div>

                <img src="{{ asset('assets/about-image-O0Uha9Ma.webp') }}" alt="" class="lg:size-112 size-72 rounded-full">

                <div class="bg-white border border-default-300 rounded-full lg:size-112 size-72 flex flex-col items-center justify-center text-center overflow-hidden p-8">
                    <img src="data:image/svg+xml,%3csvg%20width='202'%20height='40'%20viewBox='0%200%20202%2040'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M18.3225%2011.0366H26.73V32.4866H21.195V15.6791L16.455%2032.4866H10.905L6.195%2015.6791V32.4866H0.915V11.0366H9.645L13.9725%2026.5016L18.3225%2011.0366ZM33.3413%2032.4866H27.5587L34.6538%2011.0366H42.2588L49.2488%2032.4866H43.3463L42.1463%2028.0991H34.5638L33.3413%2032.4866ZM35.7788%2023.7191H40.9538L38.3888%2014.3366L35.7788%2023.7191ZM70.0177%2011.0366V32.4866H62.4877L55.3552%2016.3841V32.4866H50.0752V11.0366H58.0552L64.7377%2026.0066V11.0366H70.0177ZM71.6963%2023.9366V11.0366H77.2313V23.4416C77.2313%2026.8466%2078.6113%2028.3016%2081.1613%2028.3016C83.7188%2028.3016%2085.0913%2026.8466%2085.0913%2023.4416V11.0366H90.6263V23.9366C90.6263%2029.7191%2086.7113%2032.9366%2081.1613%2032.9366C75.6188%2032.9366%2071.6963%2029.7191%2071.6963%2023.9366ZM107.306%2011.0366V15.6266H97.8563V19.9391H106.451V24.3491H97.8563V32.4866H92.3213V11.0366H107.306ZM111.769%2032.4866H105.986L113.081%2011.0366H120.686L127.676%2032.4866H121.774L120.574%2028.0991H112.991L111.769%2032.4866ZM114.206%2023.7191H119.381L116.816%2014.3366L114.206%2023.7191ZM132.422%2021.7616C132.422%2026.0516%20134.192%2028.3016%20137.417%2028.3016C139.967%2028.3016%20141.49%2026.7866%20141.977%2023.7116H147.467C146.702%2029.4416%20142.907%2032.9366%20137.41%2032.9366C131.252%2032.9366%20126.842%2028.5416%20126.842%2021.7616C126.842%2014.9816%20131.252%2010.5866%20137.41%2010.5866C142.907%2010.5866%20146.702%2014.0816%20147.467%2019.8116H141.977C141.49%2016.7366%20139.967%2015.2216%20137.417%2015.2216C134.192%2015.2216%20132.422%2017.4641%20132.422%2021.7616ZM166.033%2011.0366V15.6266H159.688V32.4866H154.153V15.6266H147.808V11.0366H166.033ZM184.725%2011.0366V15.6266H178.38V32.4866H172.845V15.6266H166.5V11.0366H184.725Z'%20fill='%23191919'/%3e%3ccircle%20cx='193.619'%20cy='7.60001'%20r='7'%20stroke='%23191919'%20stroke-width='1.2'/%3e%3cpath%20d='M192.49%2011.2156H190.831V3.70544H194.546C196.231%203.70544%20197.257%204.59006%20197.257%205.97606C197.257%207.18881%20196.441%207.98419%20195.176%208.02356C195.769%208.06556%20196.228%208.46981%20196.556%209.20481L197.459%2011.2156H195.619L194.708%209.21006C194.441%208.61681%20194.199%208.45406%20193.58%208.45406H192.49V11.2156ZM192.49%207.11531H194.354C195.139%207.11531%20195.598%206.73469%20195.598%206.07844C195.598%205.43269%20195.152%205.07569%20194.351%205.07569H192.49V7.11531Z'%20fill='%23191919'/%3e%3c/svg%3e" alt="" class="lg:h-7.5 h-5 mb-10">

                    <div data-target="20" class="lg:text-[58px] md:text-[34px] text-[28px] text-default-900 mb-2.5"> <span class="text-primary">100</span>+</div>

                    <p class="text-base lg:w-75 w-57 mb-8">Delivering consistent manufacturing excellence since day one.</p>

                    <div class="space-y-2.5">
                        <div class="text-3xl">4.9 <span class="text-sm">/5.0</span></div>

                        <div class="lg:flex hidden gap-1.5">
                            <i class="iconify tabler--star-filled flex size-4 text-default-600"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-default-600"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-default-600"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-default-600"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-default-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-default-900 rounded-full lg:size-112 size-72 flex flex-col gap-2.5 items-center justify-center text-center overflow-hidden">
                    <div class="flex items-center justify-center xl:mb-5 mb-2.5">
                        <img src="{{ asset('assets/product-2-D35RVSms.png') }}" alt="" class="lg:h-17.5 h-15 border-2 border-default-900 rounded translate-x-2.5 -rotate-10">
                        <img src="{{ asset('assets/product-3-DpF7RVGx.png') }}" alt="" class="lg:h-17.5 h-15 border-2 border-default-900 rounded -translate-y-1.25 relative z-10">
                        <img src="{{ asset('assets/product-1-DX-qj6cp.png') }}" alt="" class="lg:h-17.5 h-15 border-2 border-default-900 rounded -translate-x-2.5 rotate-10">
                    </div>
                    <div data-target="20" class="lg:text-[58px] md:text-[34px] text-[28px] text-white mb-2.5"> 1 million<span class="text-primary">+</span></div>

                    <p class="text-default-100 lg:w-75 w-57 mb-8">Precision-crafted components delivered globally.</p>
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

    <!-- Services Features Section -->
    <section class="relative size-full lg:py-50 md:py-25 py-20">
        <div class="container-full relative z-10">
            <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                <div class="size-2 bg-primary"></div>
                <div class="text-sm text-default-900">What We Do</div>
            </div>

            <div class="grid xl:grid-cols-2 items-center xl:gap-20 gap-12.5 mt-7.5">
                <div>
                    <h1 class="lg:text-[58px] md:text-[34px] text-[28px]">Scalable <span class="text-primary">capabilities</span> for <br> every challenge</h1>
                </div>

                <div class="ms-auto">
                    <a href="{{ route('services') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-default-900 text-base font-medium text-white transition-all">
                        <!-- TEXT -->
                        <span class="py-3.75 ps-6">
                            <span class="relative block overflow-hidden">
                                <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Explore Our Capabilities
                                </span>
                                <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Explore Our Capabilities
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

            <div class="mt-17.5"></div>

            <div class="flex flex-col justify-start items-center">
                <!-- Service 1 -->
                <div class="bg-white border-t border-default-300 lg:sticky top-25">
                    <div class="flex py-10 gap-5">
                        <div class="grid md:grid-cols-5 lg:gap-10 gap-6">
                            <div class="md:col-span-2">
                                <div class="flex md:flex-row flex-col items-start lg:gap-12.5 gap-6">
                                    <img src="data:image/svg+xml,%3csvg%20width='41'%20height='41'%20viewBox='0%200%2041%2041'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M28.8139%2028.8916L20.9568%2031.7487V40.3202L27.9159%2037.8222C28.4583%2037.6053%2028.8139%2037.08%2028.8139%2036.4958V28.8916Z'%20fill='%23191919'/%3e%3cpath%20d='M11.6709%2028.8916L19.528%2031.7487V40.3202L12.5689%2037.8222C12.0265%2037.6053%2011.6709%2037.08%2011.6709%2036.4958V28.8916Z'%20fill='%23191919'/%3e%3cpath%20d='M12.3853%2027.4631L20.2424%2030.3202L28.0995%2027.4631L20.773%2024.7101C20.4324%2024.5712%2020.0524%2024.5712%2019.7118%2024.7101L12.3853%2027.4631Z'%20fill='%23191919'/%3e%3cpath%20d='M10.2424%204.60603H1.671C0.882025%204.60603%200.242432%203.96643%200.242432%203.17746V0.320312H11.671V3.17746C11.671%203.96643%2011.0314%204.60603%2010.2424%204.60603Z'%20fill='%23191919'/%3e%3cpath%20d='M25.806%2018.2523L24.3774%2015.3952C24.1347%2014.9111%2023.6408%2014.6056%2023.0995%2014.6056H21.6709V11.4852C21.2219%2011.6453%2020.7457%2011.7484%2020.2424%2011.7484C19.739%2011.7484%2019.2628%2011.6452%2018.8138%2011.4851V14.6056H17.3852C16.8439%2014.6056%2016.3501%2014.9111%2016.1073%2015.3952L14.6787%2018.2523C14.4779%2018.6548%2014.4779%2019.1278%2014.6787%2019.5302L16.1073%2022.3874C16.4603%2023.094%2017.3183%2023.3793%2018.0242%2023.0263C18.7301%2022.6734%2019.0161%2021.8154%2018.6631%2021.1095L17.554%2018.8913L18.2683%2017.4627H22.2164L22.9307%2018.8913L21.8216%2021.1095C21.4686%2021.8154%2021.7546%2022.6734%2022.4606%2023.0263C22.6656%2023.1289%2022.8833%2023.177%2023.0981%2023.177C23.6227%2023.177%2024.1263%2022.8882%2024.3774%2022.3874L25.806%2019.5302C26.0069%2019.1278%2026.0069%2018.6548%2025.806%2018.2523Z'%20fill='%23191919'/%3e%3cpath%20d='M20.2424%203.17746C21.344%203.17746%2022.3396%203.60679%2023.0995%204.29213V0.320312H17.3853V4.29213C18.1452%203.60679%2019.1408%203.17746%2020.2424%203.17746Z'%20fill='%23191919'/%3e%3cpath%20d='M20.2424%2010.3202C21.8204%2010.3202%2023.0995%209.04106%2023.0995%207.4631C23.0995%205.88514%2021.8204%204.60596%2020.2424%204.60596C18.6644%204.60596%2017.3853%205.88514%2017.3853%207.4631C17.3853%209.04106%2018.6644%2010.3202%2020.2424%2010.3202Z'%20fill='url(%23paint0_linear_70_379)'/%3e%3cpath%20d='M12.6811%2023.5956L9.81306%2020.7275C9.39%2021.6119%208.67728%2022.3246%207.79297%2022.7476L10.661%2025.6157C10.94%2025.8947%2011.3055%2026.0342%2011.6711%2026.0342C12.0366%2026.0342%2012.4021%2025.8947%2012.6811%2025.6157C13.2391%2025.0576%2013.2391%2024.1536%2012.6811%2023.5956Z'%20fill='%23191919'/%3e%3cpath%20d='M5.95661%2014.6059C7.22013%2014.6059%208.3457%2015.1657%209.13079%2016.0383L10.2423%206.03442H1.6709L2.78244%2016.0383C3.56752%2015.1657%204.6931%2014.6059%205.95661%2014.6059Z'%20fill='%23191919'/%3e%3cpath%20d='M5.95675%2021.7487C7.53471%2021.7487%208.8139%2020.4695%208.8139%2018.8916C8.8139%2017.3136%207.53471%2016.0344%205.95675%2016.0344C4.3788%2016.0344%203.09961%2017.3136%203.09961%2018.8916C3.09961%2020.4695%204.3788%2021.7487%205.95675%2021.7487Z'%20fill='url(%23paint1_linear_70_379)'/%3e%3cpath%20d='M30.2425%204.60603H38.814C39.6029%204.60603%2040.2425%203.96643%2040.2425%203.17746V0.320312H28.814V3.17746C28.814%203.96643%2029.4536%204.60603%2030.2425%204.60603Z'%20fill='%23191919'/%3e%3cpath%20d='M30.6718%2020.7275L27.8038%2023.5956C27.2457%2024.1536%2027.2457%2025.0576%2027.8038%2025.6157C28.0828%2025.8947%2028.4483%2026.0342%2028.8138%2026.0342C29.1793%2026.0342%2029.5449%2025.8947%2029.8239%2025.6157L32.6919%2022.7476C31.8076%2022.3246%2031.0949%2021.6119%2030.6718%2020.7275Z'%20fill='%23191919'/%3e%3cpath%20d='M34.5281%2014.6059C35.7917%2014.6059%2036.9172%2015.1657%2037.7023%2016.0383L38.8139%206.03442H30.2424L31.354%2016.0383C32.1391%2015.1657%2033.2646%2014.6059%2034.5281%2014.6059Z'%20fill='%23191919'/%3e%3cpath%20d='M34.528%2021.7487C36.106%2021.7487%2037.3852%2020.4695%2037.3852%2018.8916C37.3852%2017.3136%2036.106%2016.0344%2034.528%2016.0344C32.9501%2016.0344%2031.6709%2017.3136%2031.6709%2018.8916C31.6709%2020.4695%2032.9501%2021.7487%2034.528%2021.7487Z'%20fill='url(%23paint2_linear_70_379)'/%3e%3cdefs%3e%3clinearGradient%20id='paint0_linear_70_379'%20x1='17.6352'%20y1='4.67752'%20x2='22.8552'%20y2='10.0878'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23F66234'/%3e%3cstop%20offset='1'%20stop-color='%23C8370B'/%3e%3c/linearGradient%3e%3clinearGradient%20id='paint1_linear_70_379'%20x1='3.34956'%20y1='16.106'%20x2='8.5696'%20y2='21.5162'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23F66234'/%3e%3cstop%20offset='1'%20stop-color='%23C8370B'/%3e%3c/linearGradient%3e%3clinearGradient%20id='paint2_linear_70_379'%20x1='31.9208'%20y1='16.106'%20x2='37.1409'%20y2='21.5162'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23F66234'/%3e%3cstop%20offset='1'%20stop-color='%23C8370B'/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e" class="size-10">
                                    <div>
                                        <img src="{{ asset('assets/service-1-BZvdAoiD.png') }}" class="rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <div class="grid xl:grid-cols-2 gap-4">
                                    <h2 class="lg:text-3xl md:text-2xl text-xl">Product assembly</h2>

                                    <div>
                                        <div class="text-sm lg:mb-10 mb-4">Features</div>
                                        <div class="space-y-2.5">
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Manual &amp; automated assembly</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Functional testing protocols</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Custom packaging design</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Supply chain management</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="min-w-10 size-10 rounded-ee-xl rounded bg-primary text-white flex items-center justify-center">
                            <i class="iconify tabler--arrow-narrow-right size-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="bg-white border-t border-default-300 lg:sticky top-50">
                    <div class="flex py-10 gap-5">
                        <div class="grid md:grid-cols-5 lg:gap-10 gap-6">
                            <div class="md:col-span-2">
                                <div class="flex md:flex-row flex-col items-start lg:gap-12.5 gap-6">
                                    <img src="{{ asset('assets/icon-2-DxbsOQF2.svg') }}" class="size-10">
                                    <div>
                                        <img src="{{ asset('assets/service-2-G0HC8ZqU.png') }}" class="rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <div class="grid xl:grid-cols-2 gap-4">
                                    <h2 class="lg:text-3xl md:text-2xl text-xl">Sheet metal fabrication</h2>

                                    <div>
                                        <div class="text-sm lg:mb-10 mb-4">Features</div>
                                        <div class="space-y-2.5">
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Laser cutting up to 1" thickness</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Press brake forming</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>TIG / MIG welding services</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Powder coating &amp; finishing</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="min-w-10 size-10 rounded-ee-xl rounded bg-primary text-white flex items-center justify-center">
                            <i class="iconify tabler--arrow-narrow-right size-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="bg-white border-t border-default-300 lg:sticky top-150">
                    <div class="flex py-10 gap-5">
                        <div class="grid md:grid-cols-5 lg:gap-10 gap-6">
                            <div class="md:col-span-2">
                                <div class="flex md:flex-row flex-col items-start lg:gap-12.5 gap-6">
                                    <img src="{{ asset('assets/icon-3-BlpuRWaX.svg') }}" class="size-10">
                                    <div>
                                        <img src="{{ asset('assets/service-3-z7zj_aHT.png') }}" class="rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <div class="grid xl:grid-cols-2 gap-4">
                                    <h2 class="lg:text-3xl md:text-2xl text-xl">CNC machining services</h2>

                                    <div>
                                        <div class="text-sm lg:mb-10 mb-4">Features</div>
                                        <div class="space-y-2.5">
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>±0.0001" tolerance capability</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Multi-axis machining centers</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Materials: metals, plastics, composites</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Prototype to production volumes</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="min-w-10 size-10 rounded-ee-xl rounded bg-primary text-white flex items-center justify-center">
                            <i class="iconify tabler--arrow-narrow-right size-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="bg-white border-t border-default-300 lg:sticky top-200">
                    <div class="flex py-10 gap-5">
                        <div class="grid md:grid-cols-5 lg:gap-10 gap-6">
                            <div class="md:col-span-2">
                                <div class="flex md:flex-row flex-col items-start lg:gap-12.5 gap-6">
                                    <img src="data:image/svg+xml,%3csvg%20width='39'%20height='41'%20viewBox='0%200%2039%2041'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M36.4299%2010.8672H2.05493C0.97626%2010.8672%200.101807%2011.7416%200.101807%2012.8203C0.101807%2013.899%200.97626%2014.7734%202.05493%2014.7734H36.4299C37.5086%2014.7734%2038.3831%2013.899%2038.3831%2012.8203C38.3831%2011.7416%2037.5086%2010.8672%2036.4299%2010.8672Z'%20fill='url(%23paint0_linear_70_320)'/%3e%3cpath%20d='M4.78931%2026.8828C4.90454%2029.9892%209.36267%2029.9869%209.47681%2026.8828V22.1953H4.78931V26.8828Z'%20fill='%23191919'/%3e%3cpath%20d='M29.0081%2026.8828C29.1233%2029.9892%2033.5814%2029.9869%2033.6956%2026.8828V22.1953H29.0081V26.8828Z'%20fill='%23191919'/%3e%3cpath%20d='M16.8987%2039.1484C16.8987%2039.7956%2017.4234%2040.3203%2018.0706%2040.3203H20.4143C21.0615%2040.3203%2021.5862%2039.7956%2021.5862%2039.1484V32.3516H16.8987V39.1484Z'%20fill='%23191919'/%3e%3cpath%20d='M14.1643%2028.8359C14.1643%2029.4831%2014.689%2030.0078%2015.3362%2030.0078H23.1487C23.7959%2030.0078%2024.3206%2029.4831%2024.3206%2028.8359V26.8828H14.1643V28.8359Z'%20fill='url(%23paint1_linear_70_320)'/%3e%3cpath%20d='M2.44556%2018.6797C2.44556%2019.3269%202.97024%2019.8516%203.61743%2019.8516H11.8206V23.3672C11.8206%2024.0144%2012.3452%2024.5391%2012.9924%2024.5391H25.4924C26.1396%2024.5391%2026.6643%2024.0144%2026.6643%2023.3672V19.8516H34.8674C35.5146%2019.8516%2036.0393%2019.3269%2036.0393%2018.6797V17.1172H2.44556V18.6797Z'%20fill='%23191919'/%3e%3cpath%20d='M33.6956%201.49219C33.6956%200.845%2033.1709%200.320312%2032.5237%200.320312H5.96118C5.31399%200.320312%204.78931%200.845%204.78931%201.49219V8.52344H33.6956V1.49219ZM10.6487%205.59375C10.0015%205.59375%209.47681%205.06906%209.47681%204.42188C9.53423%202.86906%2011.7634%202.86953%2011.8206%204.42188C11.8206%205.06906%2011.2959%205.59375%2010.6487%205.59375ZM22.3661%205.59375H16.1161C14.5629%205.53609%2014.5641%203.30711%2016.1161%203.25H22.3661C23.9193%203.30766%2023.9181%205.53664%2022.3661%205.59375ZM27.8363%205.59375C27.5069%205.59383%2027.2096%205.45742%2026.9967%205.23859C26.2781%204.51766%2026.8057%203.24172%2027.8356%203.25H27.8364C29.3895%203.30758%2029.3884%205.53672%2027.8363%205.59375Z'%20fill='%23191919'/%3e%3cdefs%3e%3clinearGradient%20id='paint0_linear_70_320'%20x1='1.77627'%20y1='10.9161'%20x2='2.47261'%20y2='17.9889'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23F66234'/%3e%3cstop%20offset='1'%20stop-color='%23C8370B'/%3e%3c/linearGradient%3e%3clinearGradient%20id='paint1_linear_70_320'%20x1='14.6086'%20y1='26.9219'%20x2='16.1672'%20y2='32.1723'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23F66234'/%3e%3cstop%20offset='1'%20stop-color='%23C8370B'/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e" class="size-10">
                                    <div>
                                        <img src="{{ asset('assets/service-4-Dy9kmUjG.png') }}" class="rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <div class="grid xl:grid-cols-2 gap-4">
                                    <h2 class="lg:text-3xl md:text-2xl text-xl">Injection molding</h2>

                                    <div>
                                        <div class="text-sm lg:mb-10 mb-4">Features</div>
                                        <div class="space-y-2.5">
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>50–1000 ton molding machines</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Multi-cavity tooling design</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Insert molding capabilities</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="iconify tabler--check size-5 text-primary"></i>
                                                <div>Cleanroom fabrication unit</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="min-w-10 size-10 rounded-ee-xl rounded bg-primary text-white flex items-center justify-center">
                            <i class="iconify tabler--arrow-narrow-right size-6"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="relative size-full pb-12.5">
        <div class="container">
            <div class="bg-default-900 lg:p-12 p-6 bg-[url(../images/cta-bg.png)] bg-no-repeat bg-cover rounded">
                <div class="flex md:flex-row flex-col md:items-center justify-between gap-6">
                    <h2 class="lg:text-4xl md:text-3xl text-2xl text-white">Ready to start your <br>Next project?</h2>

                    <div>
                        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                            <!-- TEXT -->
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Schedule Consultation
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        Schedule Consultation
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
    </section>

    <!-- Call to Action – Ready to start your next project? -->
    <section class="relative size-full">

        <div class="xl:h-175 w-full h-full relative overflow-hidden">
            <div class="bg-[url(../images/about/vector.webp)] bg-no-repeat bg-cover bg-position-[50%] absolute top-21.5 -start-[5%] w-[130%] xl:h-175 h-150 overflow-hidden filter-[blur(30px)]"></div>
        </div>

        <div class="flex items-stretch md:justify-center justify-between xl:gap-80.5 lg:gap-75 md:gap-45 gap-0 absolute inset-0 z-1">
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
        </div>

        <div class="bg-default-900">
            <div class="container py-25 relative z-10">
                <div class="flex lg:flex-row flex-col justify-between items-start xl:gap-20 gap-12.5 mb-32.5">

                    <div class="inline-flex items-center gap-7.5 rounded-2xl py-1.25 px-3.5 bg-default-950 border border-default-800">
                        <div class="size-2 bg-primary"></div>
                        <div class="text-sm text-default-100">What we manufacture</div>
                    </div>

                    <div class="ms-auto">
                        <div data-target="50,000" class="lg:text-7xl md:text-[56px] text-[48px] leading-normal text-white mb-2.5">50,000 <span class="text-primary">+</span></div>
                        <p class="text-default-600 max-w-107">Precision-built products delivered to clients across industries and continents.</p>
                    </div>
                </div>

                <img src="{{ asset('assets/prototype-9c3AD_8A.svg') }}" alt="Product Info Image" class="size-full">
            </div>

            <div class="container-full py-25 relative z-10">
                <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-7.5" data-toggle="gallery">

                    <!-- Product 1 -->
                    <div class="bg-default-900 border border-default-700 rounded py-7.5 px-5">
                        <h3 class="text-2xl text-white mb-5">Aluminum Gear Housing</h3>
                        <a href="#">
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
                        <a href="#">
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
                        <a href="#">
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
                        <a href="#">
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

                </div>

            </div>

            <div class="container md:pb-25 pb-20 relative z-10">
                <div class="flex lg:flex-row flex-col lg:items-center items-start gap-7.5 mt-7.5">

                    <h3 class="lg:text-[42px] md:text-[34px] text-[28px] text-white">Explore our complete product range across industries.</h3>

                    <div class="grow flex flex-wrap gap-4 whitespace-nowrap">
                        <a href="{{ route('home') }}" target="_blank" class="text-white underline transition-all hover:decoration-transparent flex items-center">
                            Download Brochure
                            <i class="iconify tabler--download size-6 ms-4"></i>
                        </a>

                        <a href="{{ route('products') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-primary text-base font-medium text-white transition-all">
                            <!-- TEXT -->
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        View All Products
                                    </span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                        View All Products
                                    </span>
                                </span>
                            </span>

                            <!-- ICON -->
                            <span class="m-1.25 flex size-10 items-center justify-center rounded rounded-ee-xl bg-default-900 text-white">
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
    </section>

    <!-- Products / What We Manufacture Section -->
    <section class="relative size-full lg:py-50 md:py-25 py-20">
        <div class="container relative z-10">
            <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                <div class="size-2 bg-primary"></div>
                <div class="text-sm text-default-900">Real-world success</div>
            </div>

            <div class="grid grid-cols-2 items-end gap-12.5 mt-7.5 mb-12.5">
                <div>
                    <h1 class="lg:text-[58px] md:text-[34px] text-[28px]">Real <span class="text-primary">results</span> from real <br> projects</h1>
                </div>

                <div class="ms-auto">
                    <button class="swiper-button-prev static! group inline-flex! size-10! items-center justify-center gap-5 rounded rounded-es-2xl bg-default-200 text-default-900! text-base font-medium transition-all">
                        <span class="relative block overflow-hidden">
                            <span class="block group-hover:-translate-x-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                <i class="iconify tabler--arrow-narrow-left flex size-6"></i>
                            </span>
                            <span class="absolute top-0 start-7 group-hover:start-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                <i class="iconify tabler--arrow-narrow-left flex size-6"></i>
                            </span>
                        </span>
                    </button>

                    <button class="swiper-button-next static! group inline-flex! size-10! items-center justify-center gap-5 rounded rounded-ee-2xl bg-default-200 text-default-900! text-base font-medium transition-all">
                        <span class="relative block overflow-hidden">
                            <span class="block group-hover:translate-x-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                <i class="iconify tabler--arrow-narrow-right flex size-6"></i>
                            </span>
                            <span class="absolute top-0 end-7 group-hover:end-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                <i class="iconify tabler--arrow-narrow-right flex size-6"></i>
                            </span>
                        </span>
                    </button>
                </div>
            </div>

            <div class="swiper project-swiper">
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-5">
                            <div class="lg:col-span-2">
                                <div class="flex h-full flex-col rounded-md gap-5 bg-default-900 bg-linear-to-tr from-black via-black to-primary-3 p-10">
                                    <h3 class="text-2xl lg:text-[28px] text-white">
                                        Lightweight castings for Industrial equipment
                                    </h3>
                                    <p class="text-default-200">
                                        Redesigned metal castings to reduce material use and maintain strength, optimizing cost and weight.
                                    </p>

                                    <div class="mt-auto flex flex-wrap items-end justify-between gap-4">
                                        <div>
                                            <h3 class="mb-2.5 text-2xl md:text-4xl lg:text-[42px] text-white">35%</h3>
                                            <div class="text-default-200">Heavy-duty machinery</div>
                                        </div>

                                        <a href="{{ route('case-studies') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                                            <!-- TEXT -->
                                            <span class="py-3.75 ps-6">
                                                <span class="relative block overflow-hidden">
                                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
                                                    </span>
                                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
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

                            <div class="lg:col-span-3">
                                <div class="relative overflow-hidden rounded-md group">
                                    <img src="{{ asset('assets/product-3-fEweepR8.png') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">
                                    <img src="{{ asset('assets/2-light-DDoFchlp.svg') }}" class="absolute top-10 start-10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-5">
                            <div class="lg:col-span-2">
                                <div class="flex h-full flex-col rounded-md gap-5 bg-default-900 bg-linear-to-tr from-black via-black to-primary-3 p-10">
                                    <h3 class="text-2xl lg:text-[28px] text-white">
                                        Precision CNC milling for automotive components
                                    </h3>
                                    <p class="text-default-200">
                                        Improved machining process to achieve tighter tolerances and faster production cycles for car parts.
                                    </p>

                                    <div class="mt-auto flex items-end justify-between">
                                        <div>
                                            <h3 class="mb-2.5 text-2xl md:text-4xl lg:text-[42px] text-white">54%</h3>
                                            <div class="text-default-200">Engine parts</div>
                                        </div>

                                        <a href="{{ route('case-studies') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                                            <!-- TEXT -->
                                            <span class="py-3.75 ps-6">
                                                <span class="relative block overflow-hidden">
                                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
                                                    </span>
                                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
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

                            <div class="lg:col-span-3">
                                <div class="relative overflow-hidden rounded-md group">
                                    <img src="{{ asset('assets/product-4--sM7am50.png') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">
                                    <img src="{{ asset('assets/4-light-BP5GXLXE.svg') }}" class="absolute top-10 start-10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-5">
                            <div class="lg:col-span-2">
                                <div class="flex h-full flex-col rounded-md gap-5 bg-default-900 bg-linear-to-tr from-black via-black to-primary-3 p-10">
                                    <h3 class="text-2xl lg:text-[28px] text-white">
                                        Additive manufacturing for custom tooling
                                    </h3>
                                    <p class="text-default-200">
                                        Implemented 3D-printed tools to accelerate prototyping and reduce lead time in production.
                                    </p>

                                    <div class="mt-auto flex items-end justify-between">
                                        <div>
                                            <h3 class="mb-2.5 text-2xl md:text-4xl lg:text-[42px] text-white">50%</h3>
                                            <div class="text-default-200">Traditional tooling</div>
                                        </div>

                                        <a href="{{ route('case-studies') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                                            <!-- TEXT -->
                                            <span class="py-3.75 ps-6">
                                                <span class="relative block overflow-hidden">
                                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
                                                    </span>
                                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
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

                            <div class="lg:col-span-3">
                                <div class="relative overflow-hidden rounded-md group">
                                    <img src="{{ asset('assets/product-2-Cg8Cv16T.png') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">
                                    <img src="{{ asset('assets/5-light-B6pQZFV6.svg') }}" class="absolute top-10 start-10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-5">
                            <div class="lg:col-span-2">
                                <div class="flex h-full flex-col rounded-md gap-5 bg-default-900 bg-linear-to-tr from-black via-black to-primary-3 p-10">
                                    <h3 class="text-2xl lg:text-[28px] text-white">
                                        Automated assembly line optimization
                                    </h3>
                                    <p class="text-default-200">
                                        Streamlined assembly processes with robotics, reducing labor costs and improving output consistency.
                                    </p>

                                    <div class="mt-auto flex items-end justify-between">
                                        <div>
                                            <h3 class="mb-2.5 text-2xl md:text-4xl lg:text-[42px] text-white">40%</h3>
                                            <div class="text-default-200">Assembly process</div>
                                        </div>

                                        <a href="{{ route('case-studies') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                                            <!-- TEXT -->
                                            <span class="py-3.75 ps-6">
                                                <span class="relative block overflow-hidden">
                                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
                                                    </span>
                                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
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

                            <div class="lg:col-span-3">
                                <div class="relative overflow-hidden rounded-md group">
                                    <img src="{{ asset('assets/1-BtwCsebB.webp') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">
                                    <img src="data:image/svg+xml,%3csvg%20width='109'%20height='34'%20viewBox='0%200%20109%2034'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_748_164)'%3e%3cpath%20d='M58.4278%2026.7565L51.0343%2017.5077L57.9575%209.33008H53.3856L47.2195%2017.1158V9.33008H43.5098V26.7565H47.2195V21.4005L48.5784%2019.7807L53.856%2026.7565H58.4278Z'%20fill='white'/%3e%3cpath%20d='M67.1508%2027.0703C72.4284%2027.0703%2076.2689%2023.308%2076.2689%2018.0566C76.2689%2012.8052%2072.4284%209.04297%2067.1508%209.04297C61.8993%209.04297%2058.0588%2012.8052%2058.0588%2018.0566C58.0588%2023.308%2061.8993%2027.0703%2067.1508%2027.0703ZM67.1508%2023.7783C63.9374%2023.7783%2061.8733%2021.2963%2061.8733%2018.0566C61.8733%2014.7908%2063.9374%2012.3349%2067.1508%2012.3349C70.3646%2012.3349%2072.4544%2014.7908%2072.4544%2018.0566C72.4544%2021.2963%2070.3646%2023.7783%2067.1508%2023.7783Z'%20fill='white'/%3e%3cpath%20d='M88.33%2026.7565C91.648%2026.7565%2093.3986%2024.6663%2093.3986%2022.0537C93.3986%2019.8591%2091.9094%2018.0563%2090.0545%2017.769C91.7005%2017.4293%2093.059%2015.9662%2093.059%2013.7716C93.059%2011.4463%2091.3609%209.33008%2088.0425%209.33008H78.8723V26.7565H88.33ZM87.2329%2016.3059H82.5821V12.5175H87.2329C88.4868%2012.5175%2089.2706%2013.3275%2089.2706%2014.4248C89.2706%2015.5221%2088.4868%2016.3059%2087.2329%2016.3059ZM87.3632%2023.5429H82.5821V19.4933H87.3632C88.8264%2019.4933%2089.6103%2020.4338%2089.6103%2021.5312C89.6103%2022.7852%2088.7742%2023.5429%2087.3632%2023.5429Z'%20fill='white'/%3e%3cpath%20d='M108.528%2026.7565V23.4907H99.9061V19.5456H108.345V16.2798H99.9061V12.5959H108.528V9.33008H96.1963V26.7565H108.528Z'%20fill='white'/%3e%3cpath%20d='M33.0224%208.90736V4.70715H18.6475V0H14.049V4.70715H0V8.90736H14.0852V12.7093H3.40362V29.6188H7.74868V16.9095H14.0852V34H18.5751V16.9095H25.4909V24.8754C25.4909%2025.2737%2025.3099%2025.4547%2024.7306%2025.4547C24.1512%2025.4547%2022.0149%2025.4547%2020.2045%2025.3823C20.82%2026.541%2021.4718%2028.3877%2021.6528%2029.6188C24.4771%2029.6188%2026.541%2029.5463%2028.0618%2028.8946C29.5463%2028.2428%2029.9808%2027.0117%2029.9808%2024.9478V12.7093H18.5751V8.90736H33.0224Z'%20fill='white'/%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_748_164'%3e%3crect%20width='108.8'%20height='34'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" class="absolute top-10 start-10">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-5 md:grid-cols-2 gap-5">
                            <div class="lg:col-span-2">
                                <div class="flex h-full flex-col rounded-md gap-5 bg-default-900 bg-linear-to-tr from-black via-black to-primary-3 p-10">
                                    <h3 class="text-2xl lg:text-[28px] text-white">
                                        Surface treatment innovation for corrosion resistance
                                    </h3>
                                    <p class="text-default-200">
                                        Developed a new coating process to extend the lifespan of metal parts in harsh environments.
                                    </p>

                                    <div class="mt-auto flex items-end justify-between">
                                        <div>
                                            <h3 class="mb-2.5 text-2xl md:text-4xl lg:text-[42px] text-white">65%</h3>
                                            <div class="text-default-200">Metal parts</div>
                                        </div>

                                        <a href="{{ route('case-studies') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                                            <!-- TEXT -->
                                            <span class="py-3.75 ps-6">
                                                <span class="relative block overflow-hidden">
                                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
                                                    </span>
                                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                                        View detail
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

                            <div class="lg:col-span-3">
                                <div class="relative overflow-hidden rounded-md group">
                                    <img src="{{ asset('assets/product-5-P23PaWCJ.png') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">
                                    <img src="{{ asset('assets/5-light-B6pQZFV6.svg') }}" class="absolute top-10 start-10">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-7.5 border-default-300">

            <div class="grid lg:grid-cols-2 gap-12.5">
                <div class="flex flex-wrap items-center lg:gap-5 gap-3">
                    <div class="flex -space-x-5">
                        <img src="{{ asset('assets/avatar-1-BctzwD-q.png') }}" alt="" class="size-16 border-2 border-white rounded-full">
                        <img src="data:image/png;base64,UklGRvgEAABXRUJQVlA4IOwEAAAQFgCdASo8ADwAPm0qkkYkIiGhLB1bMIANiUAW/WmBAZNty7/TuW7koFA0uzC99hpRFNO+89NI3TE47fROzqfUvsE/rh6YHrr/dL2QP2qY61FneV6fMfWPlezGbZiB0+lzVYFtrS8AwD59flEhSW88UH63WoaxXecfchPUdKE7nq2+JtLqXa5q5tEt/7kyDszW1n+WQV/bPlERGukgZL5GmLX7K6QZzAUdtxu0FrnmOXbWK1CK+vpZwAD++uvuuFQmpRxdzgKhNSdF+ytS9fAJgWajWIchthWEUGRB7zHndumfzSnAqDCL8BL1qB1w/HUWJXp5pIQ5MADUpSJvlUYLeOvKwtwRDjuK11EocbYXsHo/ZRtt8xoKBJnmUlZ6HpIq3Op0t9NfR7rbe01VbcU4zMHp6579oxQhaUE+fu9Pdv6bQQWWXP4RUxIGscmvmoG90e1hcwNPfp+6dW8OLkCon8PtRqAQy21dGvXy8QpqOzAcd4TznjaOrZYikRwkPnk9EOMVwd1eo80fMzjC7IH3NrRRHWEm/K8jMK1SH5HrHJr0Xq/zP23Mxb0uZ1QEq/JvF2rdSDmZK9m7JCM8ZLiXh3YzL7wkUzCyPaDr66WX/VQW3ID7ZWs8hek+DdE+PYbRS93tP31XWwYq8dYlKRzVChsWv38WamqzUcTKXZ5mqvcYf3zqOxkG3y8DD3EWgO8kmEFOQ//ya2TgA/MPb45tdagQYHqmWb8sbMSuyr37Q9svMfuQa928JagojZmlo1sU0iXMBYSeqOxovgbVXdi7O/IcZlrsVESGBJWc/kv/UlsTkH0dQa13IDfMUQ1uo8/HvcXH1PXq4GVyId1fBr+xMubep8o0358l3TXmXtUrjXOlAlfnZEHUMJnRB4fxuLp4or0qgNY06ouyGIBXXwuhIK/Bl58lgqAKj/xL0sJ53yxLuh9AegwsiQ/VOP7A3CoZzN8MTEH85j/k+9/w1hb1NUk/c+tuXDA3uHDR2D/2EDx2X+YimjrXHOaK+i2z23qSGvUfwhexkDLOdyNv+qGvbNTvhG15zRY14XcI2uas2PO6NJWnaWe5iLKkdEAS5FDaqrzX2zLwNGMKaay9xyEyhkV7nBXdyTWRMgJrp89MQnywq7ifPErmvGLjQXPVh8Hp/aFLpCPXuZhwClE2nmktsxuSjm+IGQVBWqfni/89VX3neg0gzs1Y/+8seo4ppYwpnxKac5d+5P+rehWG0abSuUZ7ymljpDRQ9D/W0bh6K9M0K/l4ZbHGSgKsuzZNthBU5/Vag8WpqgKzmSKplFBqKo3pIZgBUOtolLNvlmCV2hoOwE7oF9hal09eJ4eJokYa5XX55jAjzxp8qp9CNqeH00CShrDWi238Kjkk4m9oUQQXl0zZ6Tj/CiiRZHGZz5nZodk2QgPmr0cylV+1xQyzpfU0ibIaHOZ1PF7E5KE7Ivs1/dj5V/J55/Xt8cCpK0xj1hoSXQxFSiLNV2A5IRiBj0wu5/GDF/0jOl9uxbsT4PIQDSxCpMggYh5S46qP/Z2lf4McVEWMatpmW7Xs3nn+MKFxr8mil+9SxEeX96K39dYFvGTgF5XW5lPJ+BqUtzIoG990uw0wOI/iJ2kvU86nMhn2RssA3s/i5t+zuDGSKfs1A9wh3qz/we6ntBF1e0UONetlUuEJOmgAAAA=" alt="" class="size-16 border-2 border-white rounded-full">
                    </div>

                    <div>
                        <h3 class="lg:text-[28px] text-2xl mb-2.5">Need some help?</h3>
                        <p>We're here to provide support and assistance.</p>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl text-white text-base font-medium bg-default-900 transition-all">
                        <!-- TEXT -->
                        <span class="py-3.75 ps-6">
                            <span class="relative block overflow-hidden">
                                <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Contact us Now
                                </span>
                                <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Contact us Now
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
    </section>

    <section class="relative size-full py-5">
        <div class="relative z-10 flex gap-5 flex-nowrap w-full overflow-hidden">
            <ul class="infinite-scroll-inverse flex gap-5 justify-start items-center [&amp;&gt;li]:flex [&amp;&gt;li]:items-center [&amp;&gt;li]:justify-center [&amp;&gt;li]:bg-default-100 [&amp;&gt;li]:rounded [&amp;&gt;li]:w-57 [&amp;&gt;li]:h-39 [&amp;&gt;li]:mx-auto [&amp;&gt;li&gt;img]:w-25">
                <li><img src="{{ asset('assets/1-BK1k9eNG.svg') }}" alt="client-1"></li>
                <li><img src="{{ asset('assets/2-B-fi7rK7.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='109'%20height='34'%20viewBox='0%200%20109%2034'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_678_165)'%3e%3cpath%20d='M58.4278%2026.7565L51.0343%2017.5077L57.9575%209.33008H53.3856L47.2195%2017.1158V9.33008H43.5098V26.7565H47.2195V21.4005L48.5784%2019.7807L53.856%2026.7565H58.4278Z'%20fill='%23191919'/%3e%3cpath%20d='M67.1507%2027.0703C72.4283%2027.0703%2076.2687%2023.308%2076.2687%2018.0566C76.2687%2012.8052%2072.4283%209.04297%2067.1507%209.04297C61.8992%209.04297%2058.0587%2012.8052%2058.0587%2018.0566C58.0587%2023.308%2061.8992%2027.0703%2067.1507%2027.0703ZM67.1507%2023.7783C63.9373%2023.7783%2061.8731%2021.2963%2061.8731%2018.0566C61.8731%2014.7908%2063.9373%2012.3349%2067.1507%2012.3349C70.3644%2012.3349%2072.4543%2014.7908%2072.4543%2018.0566C72.4543%2021.2963%2070.3644%2023.7783%2067.1507%2023.7783Z'%20fill='%23191919'/%3e%3cpath%20d='M88.33%2026.7565C91.648%2026.7565%2093.3986%2024.6663%2093.3986%2022.0537C93.3986%2019.8591%2091.9094%2018.0563%2090.0545%2017.769C91.7005%2017.4293%2093.059%2015.9662%2093.059%2013.7716C93.059%2011.4463%2091.3609%209.33008%2088.0425%209.33008H78.8723V26.7565H88.33ZM87.2329%2016.3059H82.5821V12.5175H87.2329C88.4868%2012.5175%2089.2706%2013.3275%2089.2706%2014.4248C89.2706%2015.5221%2088.4868%2016.3059%2087.2329%2016.3059ZM87.3632%2023.5429H82.5821V19.4933H87.3632C88.8264%2019.4933%2089.6103%2020.4338%2089.6103%2021.5312C89.6103%2022.7852%2088.7742%2023.5429%2087.3632%2023.5429Z'%20fill='%23191919'/%3e%3cpath%20d='M108.528%2026.7565V23.4907H99.9062V19.5456H108.345V16.2798H99.9062V12.5959H108.528V9.33008H96.1964V26.7565H108.528Z'%20fill='%23191919'/%3e%3cpath%20d='M33.0224%208.90736V4.70715H18.6475V0H14.049V4.70715H0V8.90736H14.0852V12.7093H3.40362V29.6188H7.74868V16.9095H14.0852V34H18.5751V16.9095H25.4909V24.8754C25.4909%2025.2737%2025.3099%2025.4547%2024.7306%2025.4547C24.1512%2025.4547%2022.0149%2025.4547%2020.2045%2025.3823C20.82%2026.541%2021.4718%2028.3877%2021.6528%2029.6188C24.4771%2029.6188%2026.541%2029.5463%2028.0618%2028.8946C29.5463%2028.2428%2029.9808%2027.0117%2029.9808%2024.9478V12.7093H18.5751V8.90736H33.0224Z'%20fill='%23191919'/%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_678_165'%3e%3crect%20width='108.8'%20height='34'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="{{ asset('assets/4-BXsuW1ly.svg') }}" alt="client-1"></li>
                <li><img src="{{ asset('assets/5-Btx3uSlX.svg') }}" alt="client-1"></li>
                <li><img src="{{ asset('assets/6-CUpVjbFW.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='91'%20height='40'%20viewBox='0%200%2091%2040'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_678_171)'%3e%3cpath%20d='M61.956%2014.1966V11.6149L55.1789%208.61821L61.956%205.75983V3.20117L52.505%207.627V9.70159L61.956%2014.1966Z'%20fill='%23191919'/%3e%3cpath%20d='M4.56377%2027.5127C5.08628%2028.4194%206.08514%2028.8728%207.56043%2028.8728C9.03569%2028.8728%2010.0269%2028.4271%2010.534%2027.5358C11.0565%2026.6444%2011.3178%2025.1538%2011.3178%2023.0638C11.3178%2020.9585%2011.0488%2019.4295%2010.511%2018.4767C9.98848%2017.5239%209.00496%2017.0475%207.56043%2017.0475C6.11586%2017.0475%205.1247%2017.5239%204.58681%2018.4767C4.04896%2019.4295%203.78003%2020.9508%203.78003%2023.0408C3.78003%2025.1154%204.04128%2026.606%204.56377%2027.5127ZM12.5395%2029.1724C11.6021%2030.4633%209.94237%2031.1087%207.56043%2031.1087C5.17846%2031.1087%203.5111%2030.4633%202.55832%2029.1724C1.60554%2027.8662%201.12915%2025.8223%201.12915%2023.0408C1.12915%2020.2593%201.60554%2018.1924%202.55832%2016.8401C3.52647%2015.4877%205.19384%2014.8115%207.56043%2014.8115C9.92703%2014.8115%2011.5867%2015.4877%2012.5395%2016.8401C13.4923%2018.177%2013.9687%2020.2439%2013.9687%2023.0408C13.9687%2025.8377%2013.4923%2027.8815%2012.5395%2029.1724ZM18.0632%2030.8551H15.5507V19.3295H18.0402V20.0441C19.162%2019.3987%2020.2224%2019.076%2021.2213%2019.076C22.758%2019.076%2023.803%2019.514%2024.3562%2020.3899C24.9248%2021.2505%2025.2091%2022.6797%2025.2091%2024.6774V30.8551H22.7196V24.7466C22.7196%2023.5018%2022.5813%2022.6182%2022.3047%2022.0957C22.0434%2021.5732%2021.4979%2021.312%2020.668%2021.312C19.8843%2021.312%2019.1313%2021.4656%2018.409%2021.773L18.0632%2021.9113V30.8551ZM27.7973%2032.7223H37.6632V34.866H27.7973V32.7223ZM40.6455%2030.8551V15.0651H50.6036V17.3011H43.2042V21.773H49.2207V23.9859H43.2042V28.5961H50.6036V30.8551H40.6455ZM50.7935%2019.3295H53.4212L55.6344%2028.7114H56.3719L58.677%2019.3295H61.2357L58.2388%2030.8551H53.7671L50.7935%2019.3295ZM70.1284%2028.7805L70.7737%2028.7114L70.8199%2030.5785C69.0678%2030.932%2067.5157%2031.1087%2066.1636%2031.1087C64.4577%2031.1087%2063.2282%2030.64%2062.4752%2029.7026C61.7377%2028.7651%2061.3689%2027.2668%2061.3689%2025.2076C61.3689%2021.1199%2063.0361%2019.076%2066.3711%2019.076C69.5979%2019.076%2071.2115%2020.8356%2071.2115%2024.3547L71.0502%2026.1527H63.9043C63.9196%2027.1055%2064.1271%2027.8047%2064.5267%2028.2503C64.9262%2028.696%2065.6717%2028.9188%2066.7627%2028.9188C67.8537%2028.9188%2068.9759%2028.8728%2070.1284%2028.7805ZM68.7451%2024.2164C68.7451%2023.0792%2068.561%2022.2878%2068.1917%2021.8421C67.8383%2021.3811%2067.2313%2021.1506%2066.3711%2021.1506C65.5104%2021.1506%2064.8801%2021.3888%2064.4805%2021.8652C64.0963%2022.3416%2063.8968%2023.1253%2063.8814%2024.2164H68.7451ZM75.0427%2030.8551H72.5302V19.3295H75.0194V20.0441C76.1412%2019.3987%2077.2018%2019.076%2078.2005%2019.076C79.7372%2019.076%2080.7825%2019.514%2081.3355%2020.3899C81.9043%2021.2505%2082.1886%2022.6797%2082.1886%2024.6774V30.8551H79.699V24.7466C79.699%2023.5018%2079.5605%2022.6182%2079.284%2022.0957C79.0229%2021.5732%2078.477%2021.312%2077.6476%2021.312C76.8638%2021.312%2076.1109%2021.4656%2075.3882%2021.773L75.0427%2021.9113V30.8551ZM90.2168%2021.4733H87.0357V26.5446C87.0357%2027.482%2087.1047%2028.1044%2087.2432%2028.4117C87.3816%2028.7191%2087.735%2028.8728%2088.3034%2028.8728L90.1935%2028.8036L90.3091%2030.809C89.2792%2031.0088%2088.4955%2031.1087%2087.9579%2031.1087C86.6515%2031.1087%2085.7526%2030.809%2085.2607%2030.2097C84.7843%2029.6104%2084.546%2028.4809%2084.546%2026.8212V21.4733H83.0708V19.3295H84.546V15.9871H87.0357V19.3295H90.2168V21.4733Z'%20fill='%23191919'/%3e%3cpath%20d='M66.2211%2017.0348L72.8137%200.806791L70.6009%200L64.0312%2016.2511L66.2211%2017.0348Z'%20fill='%23191919'/%3e%3cpath%20d='M74.2759%2014.1966L83.7269%209.70159V7.627L74.2759%203.20117V5.75983L81.0526%208.61821L74.2759%2011.6149V14.1966Z'%20fill='%23191919'/%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_678_171'%3e%3crect%20width='90.989'%20height='40'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="{{ asset('assets/8-CnKgKRq1.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='90'%20height='20'%20viewBox='0%200%2090%2020'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M30.5549%2018.8807C28.4887%2018.8807%2026.8774%2018.3093%2025.7204%2017.1659C24.5773%2016.0229%2024.0056%2014.3907%2024.0056%2012.2696V4.1709H27.3526V12.1457C27.3526%2014.7352%2028.427%2016.0298%2030.5755%2016.0298C31.6224%2016.0298%2032.4212%2015.7198%2032.9721%2015.1C33.5229%2014.4666%2033.7985%2013.4817%2033.7985%2012.1457V4.1709H37.104V12.2696C37.104%2014.3907%2036.5256%2016.0229%2035.3686%2017.1659C34.2256%2018.3093%2032.6209%2018.8807%2030.5549%2018.8807Z'%20fill='%23191919'/%3e%3cpath%20d='M38.7378%2011.5259H44.5847V14.1085H38.7378V11.5259Z'%20fill='%23191919'/%3e%3cpath%20d='M48.564%206.89801H43.936V4.1709H56.5389V6.89801H51.911V18.633H48.564V6.89801Z'%20fill='%23191919'/%3e%3cpath%20d='M68.035%207.51782V18.633H64.9775V17.3108C64.5504%2017.7927%2064.0407%2018.1647%2063.4484%2018.4264C62.8562%2018.6741%2062.2158%2018.7981%2061.5271%2018.7981C60.0673%2018.7981%2058.9103%2018.378%2058.0564%2017.538C57.2025%2016.6977%2056.7754%2015.4512%2056.7754%2013.7984V7.51782H59.9983V13.3233C59.9983%2015.1139%2060.7491%2016.0092%2062.2503%2016.0092C63.0216%2016.0092%2063.6414%2015.7612%2064.1097%2015.2654C64.5779%2014.7558%2064.812%2014.005%2064.812%2013.0134V7.51782H68.035Z'%20fill='%23191919'/%3e%3cpath%20d='M73.0661%208.98492C73.4518%208.44777%2073.9682%208.04144%2074.6155%207.76597C75.2767%207.4905%2076.0341%207.35278%2076.888%207.35278V10.3278C76.5302%2010.3003%2076.2891%2010.2865%2076.1651%2010.2865C75.2422%2010.2865%2074.5193%2010.5482%2073.9957%2011.0716C73.4724%2011.5812%2073.2107%2012.3525%2073.2107%2013.3855V18.6332H69.9878V7.51806H73.0661V8.98492Z'%20fill='%23191919'/%3e%3cpath%20d='M84.5274%207.35278C85.9049%207.35278%2087.0135%207.76597%2087.8538%208.59238C88.7077%209.41879%2089.1345%2010.6446%2089.1345%2012.2699V18.6332H85.9116V12.7657C85.9116%2011.8842%2085.7189%2011.23%2085.3332%2010.803C84.9475%2010.3623%2084.3898%2010.1419%2083.6596%2010.1419C82.8471%2010.1419%2082.1998%2010.3967%2081.7177%2010.9063C81.2355%2011.4021%2080.9944%2012.1459%2080.9944%2013.1376V18.6332H77.7715V7.51806H80.8498V8.81964C81.2769%208.35134%2081.8072%207.99323%2082.4409%207.74531C83.0743%207.48364%2083.77%207.35278%2084.5274%207.35278Z'%20fill='%23191919'/%3e%3cpath%20fill-rule='evenodd'%20clip-rule='evenodd'%20d='M9.60724%200.412225C10.1569%20-0.137408%2011.048%20-0.137408%2011.5976%200.412225L16.7445%205.5592L11.5742%2010.4946C11.012%2011.0313%2010.1211%2011.0106%209.58439%2010.4483C9.04768%209.88606%209.0684%208.99519%209.63066%208.45849L11.2181%206.9432H7.78762C5.04121%206.9432%202.81479%209.16962%202.81479%2011.916C2.81479%2014.6626%205.04121%2016.8889%207.78762%2016.8889H14.7308C15.508%2016.8889%2016.1384%2017.519%2016.1384%2018.2962C16.1384%2019.0736%2015.508%2019.7037%2014.7308%2019.7037H7.78762C3.48662%2019.7037%200%2016.2172%200%2011.916C0%207.61504%203.48662%204.12838%207.78762%204.12838H11.3331L9.60724%202.4026C9.05764%201.85297%209.05764%200.961857%209.60724%200.412225Z'%20fill='%23191919'/%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='104'%20height='26'%20viewBox='0%200%20104%2026'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_820_155)'%3e%3cpath%20opacity='0.4'%20d='M3.50399%2012.3623V25.3334H-0.000244141V15.1634L3.50399%2012.3623Z'%20fill='%23191919'/%3e%3cpath%20d='M3.50415%2012.3623V25.3334H7.0084V14.5325L3.50415%2012.3623Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.5'%20d='M10.4089%207.06396V25.333H5.73657V10.9308L10.4089%207.06396Z'%20fill='%23191919'/%3e%3cpath%20d='M10.4094%207.06396V25.333H15.0818V9.95759L10.4094%207.06396Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.6'%20d='M19.0391%200V25.3333H12.7451V5.78542L19.0391%200Z'%20fill='%23191919'/%3e%3cpath%20d='M19.0393%200V25.3333H25.3333V5.78542L19.0393%200Z'%20fill='%23191919'/%3e%3cmask%20id='mask0_820_155'%20style='mask-type:luminance'%20maskUnits='userSpaceOnUse'%20x='32'%20y='0'%20width='72'%20height='26'%3e%3cpath%20d='M103.866%200H32.9331V25.3333H103.866V0Z'%20fill='white'/%3e%3c/mask%3e%3cg%20mask='url(%23mask0_820_155)'%3e%3cpath%20d='M33.1438%2018.5693V7.3335H34.83V18.5693H33.1438ZM39.0823%2018.5693H37.461V9.86278H38.9202V10.7707L39.8281%209.86278H43.0546L43.7518%2010.5762L44.4489%209.86278H48.1456L49.2805%2010.9815V18.5693H47.6592V11.3868H44.222V18.5693H42.6006V11.3868H39.8606L39.0823%2012.084V18.5693ZM53.3007%2021.8607H51.6794V9.86278H53.1386V10.7707L54.0465%209.86278H57.3703L58.5052%2010.9815V17.4344L57.3703%2018.5693H53.3007V21.8607ZM56.8839%2011.3868H54.079L53.3007%2012.084V17.0777H56.8839V11.3868ZM62.5155%2018.5693H60.8941V9.86278H62.3533V10.9653L63.4721%209.86278H65.4825V11.4193H63.4396L62.5155%2012.2948V18.5693ZM68.4703%208.29009H66.7841V6.76604H68.4703V8.29009ZM68.4379%2018.5693H66.8166V9.86278H68.4379V18.5693ZM72.4907%2018.5693H70.8694V9.86278H72.3286V10.7707L73.2365%209.86278H76.7062L77.8411%2010.9815V18.5693H76.2036V11.3868H73.269L72.4907%2012.084V18.5693ZM84.5717%2018.5693H81.6695L80.5346%2017.4344V11.2085H79.3348V9.86278H80.5346V8.09553H82.1559V9.86278H84.3933V11.2085H82.1559V17.0453H84.5717V18.5693ZM87.8665%208.29009H86.1803V6.76604H87.8665V8.29009ZM87.8341%2018.5693H86.2128V9.86278H87.8341V18.5693ZM92.616%2018.5693H90.9947V11.2085H89.5841V9.86278H90.9947V7.73884L92.1296%206.62012H94.821V7.96582H92.616V9.86278H94.6589V11.2085H92.616V18.5693ZM96.1738%2019.1206H97.7465V20.4501H101.395V18.0992H97.1791L96.0603%2016.9804V9.86278H97.6817V16.6724H101.395V9.86278H103.016V20.7419L101.865%2021.8607H97.325L96.1738%2020.7419V19.1206Z'%20fill='%23191919'/%3e%3c/g%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_820_155'%3e%3crect%20width='103.867'%20height='25.3333'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="{{ asset('assets/11-CAPVb5z7.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='93'%20height='26'%20viewBox='0%200%2093%2026'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20opacity='0.8'%20d='M14.1924%2010.6026H20.7735L14.1924%200.650635H7.61133L14.1924%2010.6026Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.9'%20d='M7.4522%2010.6026H0.871094L7.4522%200.650635H14.0333L7.4522%2010.6026Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.6'%20d='M14.1934%2020.5547V10.6028H20.7743V20.5547H14.1934Z'%20fill='%23191919'/%3e%3cpath%20d='M0.870117%2020.5547V10.6028H7.45123V20.5547H0.870117Z'%20fill='%23191919'/%3e%3cpath%20d='M37.5999%207.02466V20.5673H34.8835V14.805H29.0823V20.5673H26.3662V7.02466H29.0823V12.593H34.8835V7.02466H37.5999Z'%20fill='%23191919'/%3e%3cpath%20d='M44.2703%2020.7419C43.2355%2020.7419%2042.3041%2020.5157%2041.4763%2020.0628C40.6485%2019.5973%2039.9954%2018.9442%2039.5168%2018.1034C39.051%2017.2625%2038.8184%2016.2923%2038.8184%2015.1931C38.8184%2014.0936%2039.0576%2013.1235%2039.5362%2012.2827C40.0276%2011.442%2040.6939%2010.7952%2041.5345%2010.3425C42.3753%209.87685%2043.3131%209.64404%2044.3478%209.64404C45.3825%209.64404%2046.3203%209.87685%2047.1611%2010.3425C48.002%2010.7952%2048.6617%2011.442%2049.1403%2012.2827C49.6316%2013.1235%2049.8775%2014.0936%2049.8775%2015.1931C49.8775%2016.2923%2049.6252%2017.2625%2049.1209%2018.1034C48.6293%2018.9442%2047.9566%2019.5973%2047.103%2020.0628C46.2621%2020.5157%2045.318%2020.7419%2044.2703%2020.7419ZM44.2703%2018.3751C44.7619%2018.3751%2045.221%2018.2585%2045.6478%2018.0258C46.0876%2017.7799%2046.4369%2017.4179%2046.6956%2016.9393C46.9542%2016.4607%2047.0836%2015.8786%2047.0836%2015.1931C47.0836%2014.1711%2046.8119%2013.3886%2046.2688%2012.8454C45.7384%2012.2892%2045.0851%2012.0111%2044.309%2012.0111C43.533%2012.0111%2042.8797%2012.2892%2042.3496%2012.8454C41.8319%2013.3886%2041.5733%2014.1711%2041.5733%2015.1931C41.5733%2016.2148%2041.8256%2017.0038%2042.3299%2017.56C42.8475%2018.1034%2043.4942%2018.3751%2044.2703%2018.3751Z'%20fill='%23191919'/%3e%3cpath%20d='M64.4427%209.66333C65.7622%209.66333%2066.8229%2010.0708%2067.6247%2010.8857C68.4395%2011.6876%2068.8472%2012.8129%2068.8472%2014.2616V20.5673H66.1308V14.6302C66.1308%2013.7895%2065.9173%2013.1492%2065.4905%2012.7095C65.0637%2012.2568%2064.4815%2012.0304%2063.7443%2012.0304C63.007%2012.0304%2062.4185%2012.2568%2061.9786%2012.7095C61.5519%2013.1492%2061.3386%2013.7895%2061.3386%2014.6302V20.5673H58.6222V14.6302C58.6222%2013.7895%2058.4087%2013.1492%2057.9819%2012.7095C57.5551%2012.2568%2056.9729%2012.0304%2056.2357%2012.0304C55.4854%2012.0304%2054.8905%2012.2568%2054.4507%2012.7095C54.0239%2013.1492%2053.8104%2013.7895%2053.8104%2014.6302V20.5673H51.0942V9.81856H53.8104V11.1185C54.1596%2010.6658%2054.6061%2010.3101%2055.1492%2010.0514C55.7053%209.7927%2056.3132%209.66333%2056.9729%209.66333C57.8138%209.66333%2058.564%209.84443%2059.2238%2010.2066C59.8832%2010.5558%2060.3942%2011.0603%2060.7564%2011.72C61.1057%2011.0991%2061.61%2010.6011%2062.2697%2010.226C62.9425%209.85088%2063.6667%209.66333%2064.4427%209.66333Z'%20fill='%23191919'/%3e%3cpath%20d='M80.6407%2014.9602C80.6407%2015.3482%2080.6147%2015.6974%2080.5632%2016.0079H72.7054C72.7699%2016.7839%2073.0416%2017.3919%2073.5202%2017.8317C73.9987%2018.2715%2074.5873%2018.4914%2075.2858%2018.4914C76.2947%2018.4914%2077.0126%2018.0579%2077.4394%2017.1913H80.369C80.0586%2018.2263%2079.4637%2019.0799%2078.5841%2019.7526C77.7044%2020.4121%2076.6246%2020.7419%2075.3439%2020.7419C74.3092%2020.7419%2073.3778%2020.5157%2072.55%2020.0628C71.7352%2019.5973%2071.0949%2018.9442%2070.6293%2018.1034C70.1765%2017.2625%2069.9502%2016.2923%2069.9502%2015.1931C69.9502%2014.0806%2070.1765%2013.1041%2070.6293%2012.2633C71.0818%2011.4225%2071.7158%2010.7758%2072.5306%2010.3231C73.3454%209.8704%2074.2832%209.64404%2075.3439%209.64404C76.3656%209.64404%2077.2776%209.86392%2078.0797%2010.3037C78.8945%2010.7435%2079.5218%2011.3708%2079.9616%2012.1857C80.4145%2012.9877%2080.6407%2013.9124%2080.6407%2014.9602ZM77.8274%2014.1841C77.8144%2013.4856%2077.5621%2012.9294%2077.0708%2012.5155C76.5792%2012.0887%2075.9776%2011.8753%2075.2664%2011.8753C74.5937%2011.8753%2074.0245%2012.0822%2073.5589%2012.4961C73.1061%2012.8971%2072.8281%2013.4598%2072.7247%2014.1841H77.8274Z'%20fill='%23191919'/%3e%3cpath%20d='M92.1305%209.8186L85.4755%2025.6507H82.5846L84.9127%2020.2957L80.6055%209.8186H83.6517L86.4263%2017.3273L89.2396%209.8186H92.1305Z'%20fill='%23191919'/%3e%3c/svg%3e" alt="client-1"></li>
            </ul>

            <ul class="infinite-scroll-inverse flex gap-5 justify-start items-center [&amp;&gt;li]:flex [&amp;&gt;li]:items-center [&amp;&gt;li]:justify-center [&amp;&gt;li]:bg-default-100 [&amp;&gt;li]:rounded [&amp;&gt;li]:w-57 [&amp;&gt;li]:h-39 [&amp;&gt;li]:mx-auto [&amp;&gt;li&gt;img]:w-25">
                <li><img src="{{ asset('assets/1-BK1k9eNG.svg') }}" alt="client-1"></li>
                <li><img src="{{ asset('assets/2-B-fi7rK7.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='109'%20height='34'%20viewBox='0%200%20109%2034'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_678_165)'%3e%3cpath%20d='M58.4278%2026.7565L51.0343%2017.5077L57.9575%209.33008H53.3856L47.2195%2017.1158V9.33008H43.5098V26.7565H47.2195V21.4005L48.5784%2019.7807L53.856%2026.7565H58.4278Z'%20fill='%23191919'/%3e%3cpath%20d='M67.1507%2027.0703C72.4283%2027.0703%2076.2687%2023.308%2076.2687%2018.0566C76.2687%2012.8052%2072.4283%209.04297%2067.1507%209.04297C61.8992%209.04297%2058.0587%2012.8052%2058.0587%2018.0566C58.0587%2023.308%2061.8992%2027.0703%2067.1507%2027.0703ZM67.1507%2023.7783C63.9373%2023.7783%2061.8731%2021.2963%2061.8731%2018.0566C61.8731%2014.7908%2063.9373%2012.3349%2067.1507%2012.3349C70.3644%2012.3349%2072.4543%2014.7908%2072.4543%2018.0566C72.4543%2021.2963%2070.3644%2023.7783%2067.1507%2023.7783Z'%20fill='%23191919'/%3e%3cpath%20d='M88.33%2026.7565C91.648%2026.7565%2093.3986%2024.6663%2093.3986%2022.0537C93.3986%2019.8591%2091.9094%2018.0563%2090.0545%2017.769C91.7005%2017.4293%2093.059%2015.9662%2093.059%2013.7716C93.059%2011.4463%2091.3609%209.33008%2088.0425%209.33008H78.8723V26.7565H88.33ZM87.2329%2016.3059H82.5821V12.5175H87.2329C88.4868%2012.5175%2089.2706%2013.3275%2089.2706%2014.4248C89.2706%2015.5221%2088.4868%2016.3059%2087.2329%2016.3059ZM87.3632%2023.5429H82.5821V19.4933H87.3632C88.8264%2019.4933%2089.6103%2020.4338%2089.6103%2021.5312C89.6103%2022.7852%2088.7742%2023.5429%2087.3632%2023.5429Z'%20fill='%23191919'/%3e%3cpath%20d='M108.528%2026.7565V23.4907H99.9062V19.5456H108.345V16.2798H99.9062V12.5959H108.528V9.33008H96.1964V26.7565H108.528Z'%20fill='%23191919'/%3e%3cpath%20d='M33.0224%208.90736V4.70715H18.6475V0H14.049V4.70715H0V8.90736H14.0852V12.7093H3.40362V29.6188H7.74868V16.9095H14.0852V34H18.5751V16.9095H25.4909V24.8754C25.4909%2025.2737%2025.3099%2025.4547%2024.7306%2025.4547C24.1512%2025.4547%2022.0149%2025.4547%2020.2045%2025.3823C20.82%2026.541%2021.4718%2028.3877%2021.6528%2029.6188C24.4771%2029.6188%2026.541%2029.5463%2028.0618%2028.8946C29.5463%2028.2428%2029.9808%2027.0117%2029.9808%2024.9478V12.7093H18.5751V8.90736H33.0224Z'%20fill='%23191919'/%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_678_165'%3e%3crect%20width='108.8'%20height='34'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="{{ asset('assets/4-BXsuW1ly.svg') }}" alt="client-1"></li>
                <li><img src="{{ asset('assets/5-Btx3uSlX.svg') }}" alt="client-1"></li>
                <li><img src="{{ asset('assets/6-CUpVjbFW.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='91'%20height='40'%20viewBox='0%200%2091%2040'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_678_171)'%3e%3cpath%20d='M61.956%2014.1966V11.6149L55.1789%208.61821L61.956%205.75983V3.20117L52.505%207.627V9.70159L61.956%2014.1966Z'%20fill='%23191919'/%3e%3cpath%20d='M4.56377%2027.5127C5.08628%2028.4194%206.08514%2028.8728%207.56043%2028.8728C9.03569%2028.8728%2010.0269%2028.4271%2010.534%2027.5358C11.0565%2026.6444%2011.3178%2025.1538%2011.3178%2023.0638C11.3178%2020.9585%2011.0488%2019.4295%2010.511%2018.4767C9.98848%2017.5239%209.00496%2017.0475%207.56043%2017.0475C6.11586%2017.0475%205.1247%2017.5239%204.58681%2018.4767C4.04896%2019.4295%203.78003%2020.9508%203.78003%2023.0408C3.78003%2025.1154%204.04128%2026.606%204.56377%2027.5127ZM12.5395%2029.1724C11.6021%2030.4633%209.94237%2031.1087%207.56043%2031.1087C5.17846%2031.1087%203.5111%2030.4633%202.55832%2029.1724C1.60554%2027.8662%201.12915%2025.8223%201.12915%2023.0408C1.12915%2020.2593%201.60554%2018.1924%202.55832%2016.8401C3.52647%2015.4877%205.19384%2014.8115%207.56043%2014.8115C9.92703%2014.8115%2011.5867%2015.4877%2012.5395%2016.8401C13.4923%2018.177%2013.9687%2020.2439%2013.9687%2023.0408C13.9687%2025.8377%2013.4923%2027.8815%2012.5395%2029.1724ZM18.0632%2030.8551H15.5507V19.3295H18.0402V20.0441C19.162%2019.3987%2020.2224%2019.076%2021.2213%2019.076C22.758%2019.076%2023.803%2019.514%2024.3562%2020.3899C24.9248%2021.2505%2025.2091%2022.6797%2025.2091%2024.6774V30.8551H22.7196V24.7466C22.7196%2023.5018%2022.5813%2022.6182%2022.3047%2022.0957C22.0434%2021.5732%2021.4979%2021.312%2020.668%2021.312C19.8843%2021.312%2019.1313%2021.4656%2018.409%2021.773L18.0632%2021.9113V30.8551ZM27.7973%2032.7223H37.6632V34.866H27.7973V32.7223ZM40.6455%2030.8551V15.0651H50.6036V17.3011H43.2042V21.773H49.2207V23.9859H43.2042V28.5961H50.6036V30.8551H40.6455ZM50.7935%2019.3295H53.4212L55.6344%2028.7114H56.3719L58.677%2019.3295H61.2357L58.2388%2030.8551H53.7671L50.7935%2019.3295ZM70.1284%2028.7805L70.7737%2028.7114L70.8199%2030.5785C69.0678%2030.932%2067.5157%2031.1087%2066.1636%2031.1087C64.4577%2031.1087%2063.2282%2030.64%2062.4752%2029.7026C61.7377%2028.7651%2061.3689%2027.2668%2061.3689%2025.2076C61.3689%2021.1199%2063.0361%2019.076%2066.3711%2019.076C69.5979%2019.076%2071.2115%2020.8356%2071.2115%2024.3547L71.0502%2026.1527H63.9043C63.9196%2027.1055%2064.1271%2027.8047%2064.5267%2028.2503C64.9262%2028.696%2065.6717%2028.9188%2066.7627%2028.9188C67.8537%2028.9188%2068.9759%2028.8728%2070.1284%2028.7805ZM68.7451%2024.2164C68.7451%2023.0792%2068.561%2022.2878%2068.1917%2021.8421C67.8383%2021.3811%2067.2313%2021.1506%2066.3711%2021.1506C65.5104%2021.1506%2064.8801%2021.3888%2064.4805%2021.8652C64.0963%2022.3416%2063.8968%2023.1253%2063.8814%2024.2164H68.7451ZM75.0427%2030.8551H72.5302V19.3295H75.0194V20.0441C76.1412%2019.3987%2077.2018%2019.076%2078.2005%2019.076C79.7372%2019.076%2080.7825%2019.514%2081.3355%2020.3899C81.9043%2021.2505%2082.1886%2022.6797%2082.1886%2024.6774V30.8551H79.699V24.7466C79.699%2023.5018%2079.5605%2022.6182%2079.284%2022.0957C79.0229%2021.5732%2078.477%2021.312%2077.6476%2021.312C76.8638%2021.312%2076.1109%2021.4656%2075.3882%2021.773L75.0427%2021.9113V30.8551ZM90.2168%2021.4733H87.0357V26.5446C87.0357%2027.482%2087.1047%2028.1044%2087.2432%2028.4117C87.3816%2028.7191%2087.735%2028.8728%2088.3034%2028.8728L90.1935%2028.8036L90.3091%2030.809C89.2792%2031.0088%2088.4955%2031.1087%2087.9579%2031.1087C86.6515%2031.1087%2085.7526%2030.809%2085.2607%2030.2097C84.7843%2029.6104%2084.546%2028.4809%2084.546%2026.8212V21.4733H83.0708V19.3295H84.546V15.9871H87.0357V19.3295H90.2168V21.4733Z'%20fill='%23191919'/%3e%3cpath%20d='M66.2211%2017.0348L72.8137%200.806791L70.6009%200L64.0312%2016.2511L66.2211%2017.0348Z'%20fill='%23191919'/%3e%3cpath%20d='M74.2759%2014.1966L83.7269%209.70159V7.627L74.2759%203.20117V5.75983L81.0526%208.61821L74.2759%2011.6149V14.1966Z'%20fill='%23191919'/%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_678_171'%3e%3crect%20width='90.989'%20height='40'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="{{ asset('assets/8-CnKgKRq1.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='90'%20height='20'%20viewBox='0%200%2090%2020'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M30.5549%2018.8807C28.4887%2018.8807%2026.8774%2018.3093%2025.7204%2017.1659C24.5773%2016.0229%2024.0056%2014.3907%2024.0056%2012.2696V4.1709H27.3526V12.1457C27.3526%2014.7352%2028.427%2016.0298%2030.5755%2016.0298C31.6224%2016.0298%2032.4212%2015.7198%2032.9721%2015.1C33.5229%2014.4666%2033.7985%2013.4817%2033.7985%2012.1457V4.1709H37.104V12.2696C37.104%2014.3907%2036.5256%2016.0229%2035.3686%2017.1659C34.2256%2018.3093%2032.6209%2018.8807%2030.5549%2018.8807Z'%20fill='%23191919'/%3e%3cpath%20d='M38.7378%2011.5259H44.5847V14.1085H38.7378V11.5259Z'%20fill='%23191919'/%3e%3cpath%20d='M48.564%206.89801H43.936V4.1709H56.5389V6.89801H51.911V18.633H48.564V6.89801Z'%20fill='%23191919'/%3e%3cpath%20d='M68.035%207.51782V18.633H64.9775V17.3108C64.5504%2017.7927%2064.0407%2018.1647%2063.4484%2018.4264C62.8562%2018.6741%2062.2158%2018.7981%2061.5271%2018.7981C60.0673%2018.7981%2058.9103%2018.378%2058.0564%2017.538C57.2025%2016.6977%2056.7754%2015.4512%2056.7754%2013.7984V7.51782H59.9983V13.3233C59.9983%2015.1139%2060.7491%2016.0092%2062.2503%2016.0092C63.0216%2016.0092%2063.6414%2015.7612%2064.1097%2015.2654C64.5779%2014.7558%2064.812%2014.005%2064.812%2013.0134V7.51782H68.035Z'%20fill='%23191919'/%3e%3cpath%20d='M73.0661%208.98492C73.4518%208.44777%2073.9682%208.04144%2074.6155%207.76597C75.2767%207.4905%2076.0341%207.35278%2076.888%207.35278V10.3278C76.5302%2010.3003%2076.2891%2010.2865%2076.1651%2010.2865C75.2422%2010.2865%2074.5193%2010.5482%2073.9957%2011.0716C73.4724%2011.5812%2073.2107%2012.3525%2073.2107%2013.3855V18.6332H69.9878V7.51806H73.0661V8.98492Z'%20fill='%23191919'/%3e%3cpath%20d='M84.5274%207.35278C85.9049%207.35278%2087.0135%207.76597%2087.8538%208.59238C88.7077%209.41879%2089.1345%2010.6446%2089.1345%2012.2699V18.6332H85.9116V12.7657C85.9116%2011.8842%2085.7189%2011.23%2085.3332%2010.803C84.9475%2010.3623%2084.3898%2010.1419%2083.6596%2010.1419C82.8471%2010.1419%2082.1998%2010.3967%2081.7177%2010.9063C81.2355%2011.4021%2080.9944%2012.1459%2080.9944%2013.1376V18.6332H77.7715V7.51806H80.8498V8.81964C81.2769%208.35134%2081.8072%207.99323%2082.4409%207.74531C83.0743%207.48364%2083.77%207.35278%2084.5274%207.35278Z'%20fill='%23191919'/%3e%3cpath%20fill-rule='evenodd'%20clip-rule='evenodd'%20d='M9.60724%200.412225C10.1569%20-0.137408%2011.048%20-0.137408%2011.5976%200.412225L16.7445%205.5592L11.5742%2010.4946C11.012%2011.0313%2010.1211%2011.0106%209.58439%2010.4483C9.04768%209.88606%209.0684%208.99519%209.63066%208.45849L11.2181%206.9432H7.78762C5.04121%206.9432%202.81479%209.16962%202.81479%2011.916C2.81479%2014.6626%205.04121%2016.8889%207.78762%2016.8889H14.7308C15.508%2016.8889%2016.1384%2017.519%2016.1384%2018.2962C16.1384%2019.0736%2015.508%2019.7037%2014.7308%2019.7037H7.78762C3.48662%2019.7037%200%2016.2172%200%2011.916C0%207.61504%203.48662%204.12838%207.78762%204.12838H11.3331L9.60724%202.4026C9.05764%201.85297%209.05764%200.961857%209.60724%200.412225Z'%20fill='%23191919'/%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='104'%20height='26'%20viewBox='0%200%20104%2026'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_820_155)'%3e%3cpath%20opacity='0.4'%20d='M3.50399%2012.3623V25.3334H-0.000244141V15.1634L3.50399%2012.3623Z'%20fill='%23191919'/%3e%3cpath%20d='M3.50415%2012.3623V25.3334H7.0084V14.5325L3.50415%2012.3623Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.5'%20d='M10.4089%207.06396V25.333H5.73657V10.9308L10.4089%207.06396Z'%20fill='%23191919'/%3e%3cpath%20d='M10.4094%207.06396V25.333H15.0818V9.95759L10.4094%207.06396Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.6'%20d='M19.0391%200V25.3333H12.7451V5.78542L19.0391%200Z'%20fill='%23191919'/%3e%3cpath%20d='M19.0393%200V25.3333H25.3333V5.78542L19.0393%200Z'%20fill='%23191919'/%3e%3cmask%20id='mask0_820_155'%20style='mask-type:luminance'%20maskUnits='userSpaceOnUse'%20x='32'%20y='0'%20width='72'%20height='26'%3e%3cpath%20d='M103.866%200H32.9331V25.3333H103.866V0Z'%20fill='white'/%3e%3c/mask%3e%3cg%20mask='url(%23mask0_820_155)'%3e%3cpath%20d='M33.1438%2018.5693V7.3335H34.83V18.5693H33.1438ZM39.0823%2018.5693H37.461V9.86278H38.9202V10.7707L39.8281%209.86278H43.0546L43.7518%2010.5762L44.4489%209.86278H48.1456L49.2805%2010.9815V18.5693H47.6592V11.3868H44.222V18.5693H42.6006V11.3868H39.8606L39.0823%2012.084V18.5693ZM53.3007%2021.8607H51.6794V9.86278H53.1386V10.7707L54.0465%209.86278H57.3703L58.5052%2010.9815V17.4344L57.3703%2018.5693H53.3007V21.8607ZM56.8839%2011.3868H54.079L53.3007%2012.084V17.0777H56.8839V11.3868ZM62.5155%2018.5693H60.8941V9.86278H62.3533V10.9653L63.4721%209.86278H65.4825V11.4193H63.4396L62.5155%2012.2948V18.5693ZM68.4703%208.29009H66.7841V6.76604H68.4703V8.29009ZM68.4379%2018.5693H66.8166V9.86278H68.4379V18.5693ZM72.4907%2018.5693H70.8694V9.86278H72.3286V10.7707L73.2365%209.86278H76.7062L77.8411%2010.9815V18.5693H76.2036V11.3868H73.269L72.4907%2012.084V18.5693ZM84.5717%2018.5693H81.6695L80.5346%2017.4344V11.2085H79.3348V9.86278H80.5346V8.09553H82.1559V9.86278H84.3933V11.2085H82.1559V17.0453H84.5717V18.5693ZM87.8665%208.29009H86.1803V6.76604H87.8665V8.29009ZM87.8341%2018.5693H86.2128V9.86278H87.8341V18.5693ZM92.616%2018.5693H90.9947V11.2085H89.5841V9.86278H90.9947V7.73884L92.1296%206.62012H94.821V7.96582H92.616V9.86278H94.6589V11.2085H92.616V18.5693ZM96.1738%2019.1206H97.7465V20.4501H101.395V18.0992H97.1791L96.0603%2016.9804V9.86278H97.6817V16.6724H101.395V9.86278H103.016V20.7419L101.865%2021.8607H97.325L96.1738%2020.7419V19.1206Z'%20fill='%23191919'/%3e%3c/g%3e%3c/g%3e%3cdefs%3e%3cclipPath%20id='clip0_820_155'%3e%3crect%20width='103.867'%20height='25.3333'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e" alt="client-1"></li>
                <li><img src="{{ asset('assets/11-CAPVb5z7.svg') }}" alt="client-1"></li>
                <li><img src="data:image/svg+xml,%3csvg%20width='93'%20height='26'%20viewBox='0%200%2093%2026'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20opacity='0.8'%20d='M14.1924%2010.6026H20.7735L14.1924%200.650635H7.61133L14.1924%2010.6026Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.9'%20d='M7.4522%2010.6026H0.871094L7.4522%200.650635H14.0333L7.4522%2010.6026Z'%20fill='%23191919'/%3e%3cpath%20opacity='0.6'%20d='M14.1934%2020.5547V10.6028H20.7743V20.5547H14.1934Z'%20fill='%23191919'/%3e%3cpath%20d='M0.870117%2020.5547V10.6028H7.45123V20.5547H0.870117Z'%20fill='%23191919'/%3e%3cpath%20d='M37.5999%207.02466V20.5673H34.8835V14.805H29.0823V20.5673H26.3662V7.02466H29.0823V12.593H34.8835V7.02466H37.5999Z'%20fill='%23191919'/%3e%3cpath%20d='M44.2703%2020.7419C43.2355%2020.7419%2042.3041%2020.5157%2041.4763%2020.0628C40.6485%2019.5973%2039.9954%2018.9442%2039.5168%2018.1034C39.051%2017.2625%2038.8184%2016.2923%2038.8184%2015.1931C38.8184%2014.0936%2039.0576%2013.1235%2039.5362%2012.2827C40.0276%2011.442%2040.6939%2010.7952%2041.5345%2010.3425C42.3753%209.87685%2043.3131%209.64404%2044.3478%209.64404C45.3825%209.64404%2046.3203%209.87685%2047.1611%2010.3425C48.002%2010.7952%2048.6617%2011.442%2049.1403%2012.2827C49.6316%2013.1235%2049.8775%2014.0936%2049.8775%2015.1931C49.8775%2016.2923%2049.6252%2017.2625%2049.1209%2018.1034C48.6293%2018.9442%2047.9566%2019.5973%2047.103%2020.0628C46.2621%2020.5157%2045.318%2020.7419%2044.2703%2020.7419ZM44.2703%2018.3751C44.7619%2018.3751%2045.221%2018.2585%2045.6478%2018.0258C46.0876%2017.7799%2046.4369%2017.4179%2046.6956%2016.9393C46.9542%2016.4607%2047.0836%2015.8786%2047.0836%2015.1931C47.0836%2014.1711%2046.8119%2013.3886%2046.2688%2012.8454C45.7384%2012.2892%2045.0851%2012.0111%2044.309%2012.0111C43.533%2012.0111%2042.8797%2012.2892%2042.3496%2012.8454C41.8319%2013.3886%2041.5733%2014.1711%2041.5733%2015.1931C41.5733%2016.2148%2041.8256%2017.0038%2042.3299%2017.56C42.8475%2018.1034%2043.4942%2018.3751%2044.2703%2018.3751Z'%20fill='%23191919'/%3e%3cpath%20d='M64.4427%209.66333C65.7622%209.66333%2066.8229%2010.0708%2067.6247%2010.8857C68.4395%2011.6876%2068.8472%2012.8129%2068.8472%2014.2616V20.5673H66.1308V14.6302C66.1308%2013.7895%2065.9173%2013.1492%2065.4905%2012.7095C65.0637%2012.2568%2064.4815%2012.0304%2063.7443%2012.0304C63.007%2012.0304%2062.4185%2012.2568%2061.9786%2012.7095C61.5519%2013.1492%2061.3386%2013.7895%2061.3386%2014.6302V20.5673H58.6222V14.6302C58.6222%2013.7895%2058.4087%2013.1492%2057.9819%2012.7095C57.5551%2012.2568%2056.9729%2012.0304%2056.2357%2012.0304C55.4854%2012.0304%2054.8905%2012.2568%2054.4507%2012.7095C54.0239%2013.1492%2053.8104%2013.7895%2053.8104%2014.6302V20.5673H51.0942V9.81856H53.8104V11.1185C54.1596%2010.6658%2054.6061%2010.3101%2055.1492%2010.0514C55.7053%209.7927%2056.3132%209.66333%2056.9729%209.66333C57.8138%209.66333%2058.564%209.84443%2059.2238%2010.2066C59.8832%2010.5558%2060.3942%2011.0603%2060.7564%2011.72C61.1057%2011.0991%2061.61%2010.6011%2062.2697%2010.226C62.9425%209.85088%2063.6667%209.66333%2064.4427%209.66333Z'%20fill='%23191919'/%3e%3cpath%20d='M80.6407%2014.9602C80.6407%2015.3482%2080.6147%2015.6974%2080.5632%2016.0079H72.7054C72.7699%2016.7839%2073.0416%2017.3919%2073.5202%2017.8317C73.9987%2018.2715%2074.5873%2018.4914%2075.2858%2018.4914C76.2947%2018.4914%2077.0126%2018.0579%2077.4394%2017.1913H80.369C80.0586%2018.2263%2079.4637%2019.0799%2078.5841%2019.7526C77.7044%2020.4121%2076.6246%2020.7419%2075.3439%2020.7419C74.3092%2020.7419%2073.3778%2020.5157%2072.55%2020.0628C71.7352%2019.5973%2071.0949%2018.9442%2070.6293%2018.1034C70.1765%2017.2625%2069.9502%2016.2923%2069.9502%2015.1931C69.9502%2014.0806%2070.1765%2013.1041%2070.6293%2012.2633C71.0818%2011.4225%2071.7158%2010.7758%2072.5306%2010.3231C73.3454%209.8704%2074.2832%209.64404%2075.3439%209.64404C76.3656%209.64404%2077.2776%209.86392%2078.0797%2010.3037C78.8945%2010.7435%2079.5218%2011.3708%2079.9616%2012.1857C80.4145%2012.9877%2080.6407%2013.9124%2080.6407%2014.9602ZM77.8274%2014.1841C77.8144%2013.4856%2077.5621%2012.9294%2077.0708%2012.5155C76.5792%2012.0887%2075.9776%2011.8753%2075.2664%2011.8753C74.5937%2011.8753%2074.0245%2012.0822%2073.5589%2012.4961C73.1061%2012.8971%2072.8281%2013.4598%2072.7247%2014.1841H77.8274Z'%20fill='%23191919'/%3e%3cpath%20d='M92.1305%209.8186L85.4755%2025.6507H82.5846L84.9127%2020.2957L80.6055%209.8186H83.6517L86.4263%2017.3273L89.2396%209.8186H92.1305Z'%20fill='%23191919'/%3e%3c/svg%3e" alt="client-1"></li>
            </ul>
        </div>
    </section>

    <!-- Blog / Insights & Article -->
    <section class="relative size-full py-37.5">
        <img src="{{ asset('assets/why-choose-DNef7VyW.png') }}" class="absolute inset-0 size-full bg-cover bg-no-repeat bg-position-[50%]">

        <div class="container">
            <div class="bg-default-900/50 rounded-md border border-white/10 [backdrop-filter:blur(5px)] max-w-132 lg:p-12.5 md:p-7.5 p-6">
                <h2 class="lg:text-[32px] md:text-[28px] text-2xl text-white mb-7.5">Manufacturing solutions you can count on</h2>

                <div class="space-y-2.5  mb-7.5">
                    <div class="flex items-center gap-2">
                        <i class="iconify tabler--check flex size-6 text-primary"></i>
                        <p class="text-default-200">Decades of experience</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="iconify tabler--check flex size-6 text-primary"></i>
                        <p class="text-default-200">Certified quality assurance</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="iconify tabler--check flex size-6 text-primary"></i>
                        <p class="text-default-200">On-time delivery</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="iconify tabler--check flex size-6 text-primary"></i>
                        <p class="text-default-200">End-to-end solutions</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="iconify tabler--check flex size-6 text-primary"></i>
                        <p class="text-default-200">Advanced technology</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="iconify tabler--check flex size-6 text-primary"></i>
                        <p class="text-default-200">Customer-centric spproach</p>
                    </div>
                </div>

                <div class="mb-7.5">
                    <a href="{{ route('services') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-primary text-base font-medium text-white transition-all">
                        <!-- TEXT -->
                        <span class="py-3.75 ps-6">
                            <span class="relative block overflow-hidden">
                                <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Our Capabilities
                                </span>
                                <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Our Capabilities
                                </span>
                            </span>
                        </span>

                        <!-- ICON -->
                        <span class="m-1.25 flex size-10 items-center justify-center rounded rounded-ee-xl bg-default-900 text-white">
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

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex -space-x-4.5">
                        <img src="data:image/png;base64,UklGRvgEAABXRUJQVlA4IOwEAAAQFgCdASo8ADwAPm0qkkYkIiGhLB1bMIANiUAW/WmBAZNty7/TuW7koFA0uzC99hpRFNO+89NI3TE47fROzqfUvsE/rh6YHrr/dL2QP2qY61FneV6fMfWPlezGbZiB0+lzVYFtrS8AwD59flEhSW88UH63WoaxXecfchPUdKE7nq2+JtLqXa5q5tEt/7kyDszW1n+WQV/bPlERGukgZL5GmLX7K6QZzAUdtxu0FrnmOXbWK1CK+vpZwAD++uvuuFQmpRxdzgKhNSdF+ytS9fAJgWajWIchthWEUGRB7zHndumfzSnAqDCL8BL1qB1w/HUWJXp5pIQ5MADUpSJvlUYLeOvKwtwRDjuK11EocbYXsHo/ZRtt8xoKBJnmUlZ6HpIq3Op0t9NfR7rbe01VbcU4zMHp6579oxQhaUE+fu9Pdv6bQQWWXP4RUxIGscmvmoG90e1hcwNPfp+6dW8OLkCon8PtRqAQy21dGvXy8QpqOzAcd4TznjaOrZYikRwkPnk9EOMVwd1eo80fMzjC7IH3NrRRHWEm/K8jMK1SH5HrHJr0Xq/zP23Mxb0uZ1QEq/JvF2rdSDmZK9m7JCM8ZLiXh3YzL7wkUzCyPaDr66WX/VQW3ID7ZWs8hek+DdE+PYbRS93tP31XWwYq8dYlKRzVChsWv38WamqzUcTKXZ5mqvcYf3zqOxkG3y8DD3EWgO8kmEFOQ//ya2TgA/MPb45tdagQYHqmWb8sbMSuyr37Q9svMfuQa928JagojZmlo1sU0iXMBYSeqOxovgbVXdi7O/IcZlrsVESGBJWc/kv/UlsTkH0dQa13IDfMUQ1uo8/HvcXH1PXq4GVyId1fBr+xMubep8o0358l3TXmXtUrjXOlAlfnZEHUMJnRB4fxuLp4or0qgNY06ouyGIBXXwuhIK/Bl58lgqAKj/xL0sJ53yxLuh9AegwsiQ/VOP7A3CoZzN8MTEH85j/k+9/w1hb1NUk/c+tuXDA3uHDR2D/2EDx2X+YimjrXHOaK+i2z23qSGvUfwhexkDLOdyNv+qGvbNTvhG15zRY14XcI2uas2PO6NJWnaWe5iLKkdEAS5FDaqrzX2zLwNGMKaay9xyEyhkV7nBXdyTWRMgJrp89MQnywq7ifPErmvGLjQXPVh8Hp/aFLpCPXuZhwClE2nmktsxuSjm+IGQVBWqfni/89VX3neg0gzs1Y/+8seo4ppYwpnxKac5d+5P+rehWG0abSuUZ7ymljpDRQ9D/W0bh6K9M0K/l4ZbHGSgKsuzZNthBU5/Vag8WpqgKzmSKplFBqKo3pIZgBUOtolLNvlmCV2hoOwE7oF9hal09eJ4eJokYa5XX55jAjzxp8qp9CNqeH00CShrDWi238Kjkk4m9oUQQXl0zZ6Tj/CiiRZHGZz5nZodk2QgPmr0cylV+1xQyzpfU0ibIaHOZ1PF7E5KE7Ivs1/dj5V/J55/Xt8cCpK0xj1hoSXQxFSiLNV2A5IRiBj0wu5/GDF/0jOl9uxbsT4PIQDSxCpMggYh5S46qP/Z2lf4McVEWMatpmW7Xs3nn+MKFxr8mil+9SxEeX96K39dYFvGTgF5XW5lPJ+BqUtzIoG990uw0wOI/iJ2kvU86nMhn2RssA3s/i5t+zuDGSKfs1A9wh3qz/we6ntBF1e0UONetlUuEJOmgAAAA=" alt="avatar-1" class="size-12.5 p-0.5 bg-white rounded-md">
                        <img src="{{ asset('assets/avatar-3-C3tMRDPM.png') }}" alt="avatar-1" class="size-12.5 p-0.5 bg-white rounded-md">
                        <img src="{{ asset('assets/avatar-4-UUYBlZFU.png') }}" alt="avatar-1" class="size-12.5 p-0.5 bg-white rounded-md">
                        <img src="{{ asset('assets/avatar-1-BctzwD-q.png') }}" alt="avatar-1" class="size-12.5 p-0.5 bg-white rounded-md">
                    </div>
                    <div>
                        <div class="flex gap-1.5 mb-2">
                            <i class="iconify tabler--star-filled flex size-4 text-white"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-white"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-white"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-white"></i>
                            <i class="iconify tabler--star-filled flex size-4 text-white"></i>
                        </div>
                        <p class="text-sm text-default-200">Happy clients worldwide</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="relative size-full lg:py-50 md:py-25 py-20">
        <div class="container-full">
            <div class="text-center mb-12.5">
                <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                    <div class="size-2 bg-primary"></div>
                    <div class="text-sm text-default-900">Built on trust</div>
                </div>
                <h1 class="lg:text-[58px] md:text-[34px] text-[28px]">Trusted by <span class="text-primary">clients</span>, proven <br> by results</h1>
            </div>

            <div class="grid lg:grid-cols-2 gap-7.5">
                <div class="flex flex-col md:flex-row gap-7.5">

                    <!-- Tab Nav -->
                    <div class="min-w-26 p-5 flex items-center justify-center rounded-md bg-default-950">
                        <nav class="flex md:flex-col flex-row flex-wrap justify-center gap-4" role="tablist" aria-orientation="vertical">

                            <!-- Tab 1 -->
                            <button type="button" class="hs-tab-active:border-primary hs-tab-active:opacity-100 border-3 border-transparent opacity-55 transition-all rounded-full active" id="tab-1" aria-selected="true" data-hs-tab="#tab-content-1" role="tab">
                                <img src="{{ asset('assets/avatar-1-BctzwD-q.png') }}" class="size-15 rounded-full">
                            </button>

                            <!-- Tab 2 -->
                            <button type="button" class="hs-tab-active:border-primary hs-tab-active:opacity-100 border-3 border-transparent opacity-55 transition-all rounded-full" id="tab-2" aria-selected="false" data-hs-tab="#tab-content-2" role="tab">
                                <img src="data:image/png;base64,UklGRvgEAABXRUJQVlA4IOwEAAAQFgCdASo8ADwAPm0qkkYkIiGhLB1bMIANiUAW/WmBAZNty7/TuW7koFA0uzC99hpRFNO+89NI3TE47fROzqfUvsE/rh6YHrr/dL2QP2qY61FneV6fMfWPlezGbZiB0+lzVYFtrS8AwD59flEhSW88UH63WoaxXecfchPUdKE7nq2+JtLqXa5q5tEt/7kyDszW1n+WQV/bPlERGukgZL5GmLX7K6QZzAUdtxu0FrnmOXbWK1CK+vpZwAD++uvuuFQmpRxdzgKhNSdF+ytS9fAJgWajWIchthWEUGRB7zHndumfzSnAqDCL8BL1qB1w/HUWJXp5pIQ5MADUpSJvlUYLeOvKwtwRDjuK11EocbYXsHo/ZRtt8xoKBJnmUlZ6HpIq3Op0t9NfR7rbe01VbcU4zMHp6579oxQhaUE+fu9Pdv6bQQWWXP4RUxIGscmvmoG90e1hcwNPfp+6dW8OLkCon8PtRqAQy21dGvXy8QpqOzAcd4TznjaOrZYikRwkPnk9EOMVwd1eo80fMzjC7IH3NrRRHWEm/K8jMK1SH5HrHJr0Xq/zP23Mxb0uZ1QEq/JvF2rdSDmZK9m7JCM8ZLiXh3YzL7wkUzCyPaDr66WX/VQW3ID7ZWs8hek+DdE+PYbRS93tP31XWwYq8dYlKRzVChsWv38WamqzUcTKXZ5mqvcYf3zqOxkG3y8DD3EWgO8kmEFOQ//ya2TgA/MPb45tdagQYHqmWb8sbMSuyr37Q9svMfuQa928JagojZmlo1sU0iXMBYSeqOxovgbVXdi7O/IcZlrsVESGBJWc/kv/UlsTkH0dQa13IDfMUQ1uo8/HvcXH1PXq4GVyId1fBr+xMubep8o0358l3TXmXtUrjXOlAlfnZEHUMJnRB4fxuLp4or0qgNY06ouyGIBXXwuhIK/Bl58lgqAKj/xL0sJ53yxLuh9AegwsiQ/VOP7A3CoZzN8MTEH85j/k+9/w1hb1NUk/c+tuXDA3uHDR2D/2EDx2X+YimjrXHOaK+i2z23qSGvUfwhexkDLOdyNv+qGvbNTvhG15zRY14XcI2uas2PO6NJWnaWe5iLKkdEAS5FDaqrzX2zLwNGMKaay9xyEyhkV7nBXdyTWRMgJrp89MQnywq7ifPErmvGLjQXPVh8Hp/aFLpCPXuZhwClE2nmktsxuSjm+IGQVBWqfni/89VX3neg0gzs1Y/+8seo4ppYwpnxKac5d+5P+rehWG0abSuUZ7ymljpDRQ9D/W0bh6K9M0K/l4ZbHGSgKsuzZNthBU5/Vag8WpqgKzmSKplFBqKo3pIZgBUOtolLNvlmCV2hoOwE7oF9hal09eJ4eJokYa5XX55jAjzxp8qp9CNqeH00CShrDWi238Kjkk4m9oUQQXl0zZ6Tj/CiiRZHGZz5nZodk2QgPmr0cylV+1xQyzpfU0ibIaHOZ1PF7E5KE7Ivs1/dj5V/J55/Xt8cCpK0xj1hoSXQxFSiLNV2A5IRiBj0wu5/GDF/0jOl9uxbsT4PIQDSxCpMggYh5S46qP/Z2lf4McVEWMatpmW7Xs3nn+MKFxr8mil+9SxEeX96K39dYFvGTgF5XW5lPJ+BqUtzIoG990uw0wOI/iJ2kvU86nMhn2RssA3s/i5t+zuDGSKfs1A9wh3qz/we6ntBF1e0UONetlUuEJOmgAAAA=" class="size-15 rounded-full">
                            </button>

                            <!-- Tab 3 -->
                            <button type="button" class="hs-tab-active:border-primary hs-tab-active:opacity-100 border-3 border-transparent opacity-55 transition-all rounded-full" id="tab-3" aria-selected="false" data-hs-tab="#tab-content-3" role="tab">
                                <img src="{{ asset('assets/avatar-3-C3tMRDPM.png') }}" class="size-15 rounded-full">
                            </button>

                            <!-- Tab 4 -->
                            <button type="button" class="hs-tab-active:border-primary hs-tab-active:opacity-100 border-3 border-transparent opacity-55 transition-all rounded-full" id="tab-4" aria-selected="false" data-hs-tab="#tab-content-4" role="tab">
                                <img src="{{ asset('assets/avatar-4-UUYBlZFU.png') }}" class="size-15 rounded-full">
                            </button>

                            <!-- Tab 5 -->
                            <button type="button" class="hs-tab-active:border-primary hs-tab-active:opacity-100 border-3 border-transparent opacity-55 transition-all rounded-full" id="tab-5" aria-selected="false" data-hs-tab="#tab-content-5" role="tab">
                                <img src="{{ asset('assets/avatar-5-DxheSeTg.png') }}" class="size-15 rounded-full">
                            </button>

                        </nav>
                    </div>
                    <!-- End Tab Nav -->

                    <!-- Tab Content -->
                    <div class="w-full rounded-md bg-default-100 p-10">

                        <!-- Content 1 -->
                        <div id="tab-content-1" class="h-full" role="tabpanel" aria-labelledby="tab-1">
                            <div class="flex h-full flex-col">
                                <div class="mb-5 flex gap-1.5">
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                </div>

                                <p class="text-default-900">
                                    The team's dedication and innovative approach transformed our ideas into reality. Every stage of the project was handled with care and expertise.
                                </p>

                                <div class="mt-auto">
                                    <h3 class="text-2xl lg:text-[28px] mb-2.5">Emily Carter</h3>
                                    <div class="text-sm text-default-600">Product Designer</div>
                                </div>
                            </div>
                        </div>

                        <!-- Content 2 -->
                        <div id="tab-content-2" class="hidden h-full" role="tabpanel" aria-labelledby="tab-2">
                            <div class="flex h-full flex-col">
                                <div class="mb-5 flex gap-1.5">
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                </div>

                                <p class="text-default-900">
                                    The precision and efficiency they demonstrated made the entire process effortless. I highly recommend them for any technical project.
                                </p>

                                <div class="mt-auto">
                                    <h3 class="text-2xl lg:text-[28px] mb-2.5">Liam Thompson</h3>
                                    <div class="text-sm text-default-600">Operations Manager</div>
                                </div>
                            </div>
                        </div>

                        <!-- Content 3 -->
                        <div id="tab-content-3" class="hidden h-full" role="tabpanel" aria-labelledby="tab-3">
                            <div class="flex h-full flex-col">
                                <div class="mb-5 flex gap-1.5">
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                </div>

                                <p class="text-default-900">
                                    Their precision engineering and attention to detail exceeded our expectations. From prototyping to delivery, the entire process was seamless.
                                </p>

                                <div class="mt-auto">
                                    <h3 class="text-2xl lg:text-[28px] mb-2.5">John Matthews</h3>
                                    <div class="text-sm text-default-600">Procurement Manager</div>
                                </div>
                            </div>
                        </div>

                        <!-- Content 4 -->
                        <div id="tab-content-4" class="hidden h-full" role="tabpanel" aria-labelledby="tab-4">
                            <div class="flex h-full flex-col">
                                <div class="mb-5 flex gap-1.5">
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                </div>

                                <p class="text-default-900">
                                    I was impressed by their professionalism and attention to detail. Communication was clear, and the final product exceeded expectations.
                                </p>

                                <div class="mt-auto">
                                    <h3 class="text-2xl lg:text-[28px] mb-2.5">Sofia Ramirez</h3>
                                    <div class="text-sm text-default-600">Marketing Lead at BrightWave Tech</div>
                                </div>
                            </div>
                        </div>

                        <!-- Content 5 -->
                        <div id="tab-content-5" class="hidden h-full" role="tabpanel" aria-labelledby="tab-5">
                            <div class="flex h-full flex-col">
                                <div class="mb-5 flex gap-1.5">
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                    <i class="iconify tabler--star-filled size-5 text-primary"></i>
                                </div>

                                <p class="text-default-900">
                                    The level of professionalism and commitment to quality was exceptional. Every detail was meticulously handled.
                                </p>

                                <div class="mt-auto">
                                    <h3 class="text-2xl lg:text-[28px] mb-2.5">Ethan Brooks</h3>
                                    <div class="text-sm text-default-600">Project Coordinator at Stellar Industries</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Tab Content -->
                </div>


                <div class="grid md:grid-cols-7 gap-7.5">
                    <div class="md:col-span-4 space-y-7.5">
                        <div class="relative overflow-hidden rounded-md bg-[url(../images/review-bg.png)] h-70 w-full flex flex-col items-center justify-center bg-cover bg-no-repeat bg-position-[50%]">
                            <div class="bg-default-900/60 absolute inset-0 z-1"></div>

                            <div class="relative text-center z-10">
                                <div class="text-sm text-white mb-2">// 2005-2K25 //</div>
                                <img src="data:image/svg+xml,%3csvg%20width='1803'%20height='206'%20viewBox='0%200%201803%20206'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M160.371%204.14573H237.827V201.759H186.834V46.9158L143.166%20201.759H92.0351L48.6432%2046.9158V201.759H0V4.14573H80.4271L120.295%20146.621L160.371%204.14573ZM298.735%20201.759H245.461L310.826%204.14573H380.889L445.286%20201.759H390.908L379.853%20161.338H309.997L298.735%20201.759ZM321.191%20120.986H368.867L345.236%2034.5477L321.191%20120.986ZM636.624%204.14573V201.759H567.252L501.543%2053.4108V201.759H452.899V4.14573H526.417L587.981%20142.06V4.14573H636.624ZM652.089%20122.99V4.14573H703.081V118.43C703.081%20149.799%20715.795%20163.203%20739.287%20163.203C762.849%20163.203%20775.493%20149.799%20775.493%20118.43V4.14573H826.486V122.99C826.486%20176.262%20790.418%20205.904%20739.287%20205.904C688.226%20205.904%20652.089%20176.262%20652.089%20122.99ZM980.151%204.14573V46.4321H893.094V86.162H972.274V126.79H893.094V201.759H842.101V4.14573H980.151ZM1021.27%20201.759H967.99L1033.35%204.14573H1103.42L1167.81%20201.759H1113.44L1102.39%20161.338H1032.53L1021.27%20201.759ZM1043.72%20120.986H1091.39L1067.76%2034.5477L1043.72%20120.986ZM1211.54%20102.952C1211.54%20142.475%201227.84%20163.203%201257.56%20163.203C1281.05%20163.203%201295.08%20149.246%201299.57%20120.917H1350.14C1343.1%20173.706%201308.13%20205.904%201257.49%20205.904C1200.76%20205.904%201160.13%20165.415%201160.13%20102.952C1160.13%2040.4899%201200.76%200%201257.49%200C1308.13%200%201343.1%2032.1985%201350.14%2084.9874H1299.57C1295.08%2056.6583%201281.05%2042.701%201257.56%2042.701C1227.84%2042.701%201211.54%2063.3605%201211.54%20102.952ZM1521.19%204.14573V46.4321H1462.73V201.759H1411.74V46.4321H1353.29V4.14573H1521.19ZM1693.39%204.14573V46.4321H1634.94V201.759H1583.94V46.4321H1525.49V4.14573H1693.39Z'%20fill='white'/%3e%3cpath%20d='M1761.83%207.72616C1782.49%207.72617%201799.23%2024.4721%201799.23%2045.1295C1799.23%2065.7869%201782.49%2082.5328%201761.83%2082.5328C1741.17%2082.5328%201724.43%2065.7869%201724.43%2045.1295C1724.43%2024.4721%201741.17%207.72616%201761.83%207.72616Z'%20stroke='white'%20stroke-width='7.01316'/%3e%3cpath%20d='M1755.23%2066.26H1745.54V22.3684H1767.25C1777.09%2022.3684%201783.09%2027.5383%201783.09%2035.6385C1783.09%2042.7262%201778.32%2047.3747%201770.93%2047.6048C1774.39%2047.8502%201777.08%2050.2128%201778.99%2054.5083L1784.27%2066.26H1773.52L1768.19%2054.539C1766.63%2051.0719%201765.22%2050.1207%201761.6%2050.1207H1755.23V66.26ZM1755.23%2042.2967H1766.12C1770.71%2042.2967%201773.4%2040.0722%201773.4%2036.2369C1773.4%2032.4629%201770.79%2030.3765%201766.11%2030.3765H1755.23V42.2967Z'%20fill='white'/%3e%3c/svg%3e" alt="" class="h-5">
                            </div>
                        </div>

                        <div class="bg-primary rounded-md p-10">
                            <div class="flex gap-6">
                                <div>
                                    <p data-target="98" class="count lg:text-[32px] text-[28px] text-white mb-2.5">98 <span class="text-default-900">%</span></p>
                                    <p class="text-white">On-Time delivery rate</p>
                                </div>

                                <div>
                                    <p data-target="98" class="count lg:text-[32px] text-[28px] text-white mb-2.5">50 <span class="text-default-900">+</span></p>
                                    <p class="text-white">Skilled professionals</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-3">
                        <div class="flex h-full flex-col gap-7.5 justify-between items-start rounded-md bg-default-900 bg-linear-to-tr from-black via-black to-primary-3 p-10">
                            <img src="{{ asset('assets/contact-use-icon-D8H3hD3j.svg') }}" alt="" class="h-12.5">

                            <div>
                                <h3 class="lg:text-[28px] text-2xl text-white mb-5">Need help choosing the right product?</h3>
                                <p class="text-white">Always ready with guidance, product details, and after-sales support.</p>
                            </div>

                            <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-base font-medium text-default-900 transition-all">
                                <!-- TEXT -->
                                <span class="py-3.75 ps-6">
                                    <span class="relative block overflow-hidden">
                                        <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            Contact Support
                                        </span>
                                        <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                            Contact Support
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
    </section>

    <!-- Blog / Insights & Article -->
    <section class="relative size-full pb-10">
        <div class="container">

            <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-7.5">
                <div class="lg:col-span-1 md:col-span-2">
                    <div class="inline-flex items-center gap-1.5 rounded-2xl py-1.25 px-3.5 bg-white border border-default-300">
                        <div class="size-2 bg-primary"></div>
                        <div class="text-sm text-default-900">Insights &amp; Article</div>
                    </div>

                    <h1 class="lg:text-[58px] md:text-[34px] text-[28px] my-5">Latest from our <span class="text-primary">blog</span></h1>

                    <a href="{{ route('blog') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl text-white text-base font-medium bg-default-900 transition-all">
                        <!-- TEXT -->
                        <span class="py-3.75 ps-6">
                            <span class="relative block overflow-hidden">
                                <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    View all Blog
                                </span>
                                <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    View all Blog
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

                <div class="relative overflow-hidden rounded-md group">
                    <a href="{{ route('home') }}" class="absolute inset-0 z-10"></a>
                    <img src="{{ asset('assets/blog-8-i2IkvBct.png') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">

                    <div class="bg-linear-to-b from-transparent to-default-900/80 absolute inset-0 z-1 flex flex-col items-start justify-end p-6">
                        <h3 class="lg:text-[28px] text-2xl text-white mb-2.5">Breakthroughs powering manufacturing efficiency</h3>
                        <div class="underline text-primary-1">Read full blog</div>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-md group">
                    <a href="{{ route('home') }}" class="absolute inset-0 z-10"></a>
                    <img src="{{ asset('assets/blog-1-D1EzCJZ9.png') }}" class="rounded-md w-full h-100 object-cover overflow-hidden transition-all duration-500 group-hover:scale-110">

                    <div class="bg-linear-to-b from-transparent to-default-900/80 absolute inset-0 z-1 flex flex-col items-start justify-end p-6">
                        <h3 class="lg:text-[28px] text-2xl text-white mb-2.5">Breakthroughs powering manufacturing efficiency</h3>
                        <div class="underline text-primary-1">Read full blog</div>
                    </div>
                </div>
            </div>

            <div class="mt-12.5 text-center">

            </div>

        </div>
    </section>

    <!-- Footer -->
@endsection
