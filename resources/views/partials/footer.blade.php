<footer id="footer" class="relative overflow-hidden text-white">
    
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
                    <!-- Newsletter -->
                    <div class="lg:w-105">
                        <h4 class="text-[32px] text-white mb-6.5">Stay connected</h4>
    
                        <p class="text-default-600 mb-5">
                            Join our newsletter for tips, updates, and project highlights—only the good stuff.
                        </p>
    
                        <form class="relative">
                            <input type="email" placeholder="Enter your email" class="bg-default-950 rounded-xl border-default-800 h-15 flex items-center w-full ps-4 pe-12 py-3 text-sm placeholder:text-white/50">
    
                            <span class="absolute end-2.5 top-1/2 -translate-y-1/2">
                                <button class="text-default-900 bg-white rounded size-10 inline-flex items-center justify-center">
                                    <i class="iconify tabler--arrow-narrow-right size-6"></i>
                                </button>
                            </span>
                        </form>
                    </div>
                </div>
    
                <div class="xl:col-span-4">
                    <div class="grid lg:grid-cols-9 md:grid-cols-4 grid-cols-2 lg:gap-10 gap-6">
                        <!-- Main links -->
                        <div class="lg:col-span-2">
                            <h5 class="lg:text-[28px] md:text-2xl text-lg text-white mb-7.5">Main Links</h5>
    
                            <ul class="space-y-4 text-white/70">
                                <li><a href="{{ route('home') }}" class="text-default-400 hover:text-primary">Home</a></li>
                                <li><a href="{{ route('about') }}" class="text-default-400 hover:text-primary">About</a></li>
                                <li><a href="{{ route('products') }}" class="text-default-400 hover:text-primary">Products</a></li>
                                <li><a href="{{ route('services') }}" class="text-default-400 hover:text-primary">Services</a></li>
                                <li><a href="{{ route('case-studies') }}" class="text-default-400 hover:text-primary">Case Studies</a></li>
                            </ul>
                        </div>
    
                        <!-- Utility links -->
                        <div class="lg:col-span-2">
                            <h5 class="lg:text-[28px] md:text-2xl text-lg text-white mb-7.5">Other Links</h5>
    
                            <ul class="space-y-4 text-white/70">
                                <li><a href="{{ route('blog') }}" class="text-default-400 hover:text-primary">Blog</a></li>
                                <li><a href="{{ route('contact') }}" class="text-default-400 hover:text-primary">Contact</a></li>
                                <li><a href="{{ route('faqs') }}" class="text-default-400 hover:text-primary">FAQs</a></li>
                                <li><a href="{{ route('privacy-policy') }}" class="text-default-400 hover:text-primary">Privacy Policy</a></li>
                                <li><a href="{{ route('error-404') }}" class="text-default-400 hover:text-primary">Error 404</a></li>
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
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-sm text-white/60">
    
                <p>Powered by <a href="{{ route('home') }}" target="_blank" class="underline">Unifato</a></p>
    
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white">
                        <i class="iconify tabler--brand-facebook-filled size-4"></i>
                        Facebook
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white">
                        <i class="iconify tabler--brand-x-filled size-4"></i>
                        Twitter
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 hover:text-white">
                        <i class="iconify tabler--brand-instagram-filled size-4"></i>
                        Instagram
                    </a>
                </div>
            </div>
        </div>
    
        <!-- Huge background text -->
        <div class="lg:text-[15em] md:text-[7em] text-[4em] lg:-mt-25 translate-y-1/2 font-bold text-white/5 text-center leading-none pointer-events-none">
            MANUFACTT<sup class="text-[0.75em]">®</sup>
        </div>
    
    </footer>