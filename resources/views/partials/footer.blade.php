<footer id="footer" class="relative overflow-hidden text-white" @if (($cmsEditorPage ?? null) === 'privacy-policy') data-cms-editor-ignore @endif>
    
        <!-- Background -->
        <div class="absolute inset-0 bg-linear-to-br from-black via-black to-[#8c3b2a]"></div>
    
        <div class="flex items-stretch md:justify-center justify-between xl:gap-80.5 lg:gap-75 md:gap-45 gap-0 absolute inset-0">
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
            <div class="border border-dashed border-default-100 w-0.5 h-full opacity-7"></div>
        </div>
    
        <!-- Content -->
        <div class="container-full relative z-10 lg:pt-50 pt-25">
    
            <!-- Top grid -->
            <div class="grid xl:grid-cols-6 lg:gap-25 gap-12">
    
                <div class="xl:col-span-2">
                    <div class="lg:w-105" data-cms-ignore>
                        <h4 class="text-[32px] text-white mb-6.5">Let's build together</h4>
    
                        <p class="text-default-600 mb-5">
                            Have a manufacturing project in mind? Tell us what you need, and our team will get in touch.
                        </p>
    
                        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-5 rounded rounded-ee-2xl bg-white text-sm font-medium text-default-900" data-cms-ignore>
                            <span class="py-3.75 ps-6">
                                <span class="relative block overflow-hidden">
                                    <span class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">Contact us</span>
                                    <span class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]" aria-hidden="true">Contact us</span>
                                </span>
                            </span>
                            <span class="m-1.25 flex size-10 items-center justify-center rounded rounded-ee-xl bg-primary text-white" aria-hidden="true">
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
    
                <div class="xl:col-span-4">
                    <div class="grid lg:grid-cols-9 md:grid-cols-4 grid-cols-2 lg:gap-10 gap-6">
                        <!-- Main links -->
                        <div class="lg:col-span-2">
                            <h5 class="lg:text-[28px] md:text-2xl text-lg text-white mb-7.5" data-cms-ignore>Main Links</h5>
    
                            <ul class="space-y-4 text-white/70">
                                <li><a href="{{ route('home') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Home</a></li>
                                <li><a href="{{ route('about') }}" class="text-default-400 hover:text-primary" data-cms-ignore>About</a></li>
                                <li><a href="{{ route('products') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Products</a></li>
                                <li><a href="{{ route('services') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Services</a></li>
                                <li><a href="{{ route('projects') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Projects</a></li>
                                <li><a href="{{ route('case-studies') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Case Studies</a></li>
                            </ul>
                        </div>
    
                        <!-- Utility links -->
                        <div class="lg:col-span-2">
                            <h5 class="lg:text-[28px] md:text-2xl text-lg text-white mb-7.5" data-cms-ignore>Other Links</h5>
    
                            <ul class="space-y-4 text-white/70">
                                <li><a href="{{ route('blog') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Blog</a></li>
                                <li><a href="{{ route('contact') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Contact</a></li>
                                <li><a href="{{ route('career.index') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Career</a></li>
                                <li><a href="{{ route('faqs') }}" class="text-default-400 hover:text-primary" data-cms-ignore>FAQs</a></li>
                                <li><a href="{{ route('privacy-policy') }}" class="text-default-400 hover:text-primary" data-cms-ignore>Privacy Policy</a></li>
                            </ul>
                        </div>
    
                        <!-- Contact info -->
                        <div class="lg:col-span-3">
                            <h5 class="lg:text-[28px] md:text-2xl text-lg text-white mb-7.5">Contact Info</h5>
    
                            <ul class="space-y-4 text-white/70">
                                <li>
                                    1238 echo ridge blvd, suite 400,<br>
                                    san francisco, CA 94103
                                </li>
                                <li><a href="{{ route('home') }}" class="text-default-400 hover:text-primary">+1 (415) 555-0167</a></li>
                                <li><a href="{{ route('home') }}" class="text-default-400 hover:text-primary">example@gmail.com</a></li>
                            </ul>
                        </div>
    
                        <!-- Working hours -->
                        <div class="lg:col-span-2">
                            <h5 class="lg:text-[28px] md:text-2xl text-lg text-white mb-7.5">Working Hours</h5>
    
                            <ul class="space-y-4 text-white/70">
                                <li>Mon to Fri: 8:00am – 4:00pm</li>
                                <li>Saturday: 8:00am – 1:00pm</li>
                                <li>Sunday: Closed</li>
                            </ul>
                        </div>
                    </div>
                </div>
    
            </div>
    
            <!-- Divider -->
            <div class="border border-dashed h-px border-default-100 opacity-10 my-16 lg:-mx-12.5 md:-mx-7.5 -mx-3.75"></div>
    
            <!-- Bottom bar -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6 text-sm text-white/60">
    
                <p class="text-center lg:text-left" data-cms-ignore>Powered by <a href="{{ route('home') }}" class="underline hover:text-white">Haripriya Consultancy Services Private Limited</a></p>
    
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white" data-cms-ignore>
                        <i class="iconify tabler--brand-facebook-filled size-4"></i>
                        Facebook
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white" data-cms-ignore>
                        <i class="iconify tabler--brand-x-filled size-4"></i>
                        Twitter
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white" data-cms-ignore>
                        <i class="iconify tabler--brand-instagram-filled size-4"></i>
                        Instagram
                    </a>
                </div>
                <p class="flex items-center justify-center gap-1 whitespace-nowrap lg:justify-end" data-cms-ignore>
                    <img src="{{ asset('assets/pragatiya-logo.png') }}" alt="" class="size-5 shrink-0 object-contain" aria-hidden="true">
                    <span>Developed by</span>
                    <a href="https://pragatiya.co.in/" target="_blank" rel="noopener noreferrer" class="underline hover:text-white">Pragatiya Technologies</a>
                </p>
            </div>
        </div>
    
        <!-- Huge background text -->
        <div class="lg:text-[15em] md:text-[7em] text-[4em] lg:-mt-25 translate-y-1/2 font-bold text-white/5 text-center leading-none pointer-events-none">
            HARIPRIYA<sup class="text-[0.75em]">®</sup>
        </div>
    
    </footer>
