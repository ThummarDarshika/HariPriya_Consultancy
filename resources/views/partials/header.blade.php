<header>
    <div
        class="nav-sticky navbar fixed inset-x-0 top-0 z-120 w-full border-b lg:border-transparent lg:bg-transparent border-default-200 bg-body-bg transition-all duration-300 lg:[.nav-sticky-on]:border-default-200 [.nav-sticky-on]:bg-body-bg">
        <div class="container-full py-4.5">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="data:image/svg+xml,%3csvg%20width='202'%20height='40'%20viewBox='0%200%20202%2040'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M18.3225%2011.0366H26.73V32.4866H21.195V15.6791L16.455%2032.4866H10.905L6.195%2015.6791V32.4866H0.915V11.0366H9.645L13.9725%2026.5016L18.3225%2011.0366ZM33.3413%2032.4866H27.5587L34.6538%2011.0366H42.2588L49.2488%2032.4866H43.3463L42.1463%2028.0991H34.5638L33.3413%2032.4866ZM35.7788%2023.7191H40.9538L38.3888%2014.3366L35.7788%2023.7191ZM70.0177%2011.0366V32.4866H62.4877L55.3552%2016.3841V32.4866H50.0752V11.0366H58.0552L64.7377%2026.0066V11.0366H70.0177ZM71.6963%2023.9366V11.0366H77.2313V23.4416C77.2313%2026.8466%2078.6113%2028.3016%2081.1613%2028.3016C83.7188%2028.3016%2085.0913%2026.8466%2085.0913%2023.4416V11.0366H90.6263V23.9366C90.6263%2029.7191%2086.7113%2032.9366%2081.1613%2032.9366C75.6188%2032.9366%2071.6963%2029.7191%2071.6963%2023.9366ZM107.306%2011.0366V15.6266H97.8563V19.9391H106.451V24.3491H97.8563V32.4866H92.3213V11.0366H107.306ZM111.769%2032.4866H105.986L113.081%2011.0366H120.686L127.676%2032.4866H121.774L120.574%2028.0991H112.991L111.769%2032.4866ZM114.206%2023.7191H119.381L116.816%2014.3366L114.206%2023.7191ZM132.422%2021.7616C132.422%2026.0516%20134.192%2028.3016%20137.417%2028.3016C139.967%2028.3016%20141.49%2026.7866%20141.977%2023.7116H147.467C146.702%2029.4416%20142.907%2032.9366%20137.41%2032.9366C131.252%2032.9366%20126.842%2028.5416%20126.842%2021.7616C126.842%2014.9816%20131.252%2010.5866%20137.41%2010.5866C142.907%2010.5866%20146.702%2014.0816%20147.467%2019.8116H141.977C141.49%2016.7366%20139.967%2015.2216%20137.417%2015.2216C134.192%2015.2216%20132.422%2017.4641%20132.422%2021.7616ZM166.033%2011.0366V15.6266H159.688V32.4866H154.153V15.6266H147.808V11.0366H166.033ZM184.725%2011.0366V15.6266H178.38V32.4866H172.845V15.6266H166.5V11.0366H184.725Z'%20fill='%23191919'/%3e%3ccircle%20cx='193.619'%20cy='7.60001'%20r='7'%20stroke='%23191919'%20stroke-width='1.2'/%3e%3cpath%20d='M192.49%2011.2156H190.831V3.70544H194.546C196.231%203.70544%20197.257%204.59006%20197.257%205.97606C197.257%207.18881%20196.441%207.98419%20195.176%208.02356C195.769%208.06556%20196.228%208.46981%20196.556%209.20481L197.459%2011.2156H195.619L194.708%209.21006C194.441%208.61681%20194.199%208.45406%20193.58%208.45406H192.49V11.2156ZM192.49%207.11531H194.354C195.139%207.11531%20195.598%206.73469%20195.598%206.07844C195.598%205.43269%20195.152%205.07569%20194.351%205.07569H192.49V7.11531Z'%20fill='%23191919'/%3e%3c/svg%3e"
                        class="w-40.75">
                </a>

                <div id="navbar" class="mx-auto hidden lg:flex items-center justify-center">
                    <a href="{{ route('home') }}"
                        class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                        <span
                            class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                        Home
                    </a>

                    <a href="{{ route('about') }}"
                        class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                        <span
                            class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                        About
                    </a>

                    <a href="{{ route('products') }}"
                        class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                        <span
                            class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                        Products
                    </a>

                    {{-- <div class="hs-dropdown relative inline-flex [--trigger:hover]">
                            <button type="button" class="hs-dropdown-toggle group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                <span class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                                Pages
                                <i class="iconify tabler--chevron-down ms-3"></i>
                            </button>
    
                            <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 mt-2 hidden w-45 rounded-lg border border-default-200 bg-white p-2 opacity-0 transition-[opacity,margin] duration-300 before:absolute before:start-0 before:-top-4 before:h-4 before:w-full after:absolute after:start-0 after:-bottom-4 after:h-4 after:w-full" role="menu" aria-orientation="vertical">
                                <div class="flex flex-col gap-1">
                                    <a href="{{ route('home') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Home </a>
                                    <a href="{{ route('about') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">About</a>
                                    <a href="{{ route('services') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Services</a>
                                    <a href="{{ route('case-studies') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Case Studies</a>
                                    <a href="{{ route('products') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Products</a>
                                    <a href="{{ route('blog') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Blog</a>
                                    <a href="{{ route('blog-detail') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Blog Details</a>
                                    <a href="{{ route('faqs') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">FAQs</a>
                                    <a href="{{ route('contact') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Contact</a>
                                    <a href="{{ route('privacy-policy') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">Privacy Policy</a>
                                    <a href="{{ route('error-404') }}" class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary" tabindex="0">404</a>
                                </div>
                            </div>
                        </div> --}}

                    <a href="{{ route('services') }}"
                        class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                        <span
                            class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                        Services
                    </a>

                    <a href="{{ route('contact') }}"
                        class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                        <span
                            class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                        Contact
                    </a>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('contact') }}"
                        class="group md:inline-flex hidden items-center gap-5 rounded rounded-ee-2xl bg-primary text-base font-medium text-white transition-all">
                        <!-- TEXT -->
                        <span class="py-3.75 ps-6">
                            <span class="relative block overflow-hidden">
                                <span
                                    class="block group-hover:-translate-y-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Get A Quote
                                </span>
                                <span
                                    class="absolute top-7 start-0 group-hover:top-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    Get A Quote
                                </span>
                            </span>
                        </span>

                        <!-- ICON -->
                        <span
                            class="m-1.25 flex size-10 items-center justify-center rounded rounded-ee-xl bg-default-900 text-white">
                            <span class="relative block overflow-hidden">
                                <span
                                    class="block group-hover:translate-x-7 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    <i class="iconify tabler--arrow-narrow-right flex size-6"></i>
                                </span>
                                <span
                                    class="absolute top-0 end-7 group-hover:end-0 duration-[1.125s] ease-[cubic-bezier(0.19,1,0.22,1)]">
                                    <i class="iconify tabler--arrow-narrow-right flex size-6"></i>
                                </span>
                            </span>
                        </span>
                    </a>

                    <div class="flex items-center lg:hidden">
                        <button type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="mobile-menu"
                            data-hs-overlay="#mobile-menu"
                            class="inline-flex size-12 items-center justify-center rounded-md bg-linear-to-tr from-primary-1 to-primary-2 text-base font-medium text-white transition-all">
                            <i class="iconify tabler--align-right size-6"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mobile-menu"
        class="hs-overlay hs-overlay-open:translate-y-0 hs-overlay-open:top-21 [--body-scroll:true] fixed inset-x-0 top-0 z-110 h-78 -translate-y-full transform overflow-hidden bg-body-bg shadow-xl transition-all duration-300 lg:hidden"
        role="dialog" tabindex="-1" aria-labelledby="mobile-menu-label">
        <div class="flex max-h-78 flex-col gap-1 divide-y divide-default-200 overflow-y-auto">
            <a href="{{ route('home') }}"
                class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                <span
                    class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                Home
            </a>

            <a href="{{ route('about') }}"
                class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                <span
                    class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                About
            </a>

            <div class="hs-accordion">
                <button type="button"
                    class="hs-accordion-toggle group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <span
                        class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                    Pages
                    <i class="iconify tabler--chevron-down ms-4"></i>
                </button>

                <div class="hs-accordion-content hidden w-full overflow-hidden ps-5 pb-4 transition-[height]">
                    <a href="{{ route('home') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Home </a>
                    <a href="{{ route('about') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">About</a>
                    <a href="{{ route('services') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Services</a>
                    <a href="{{ route('case-studies') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Case Studies</a>
                    <a href="{{ route('products') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Products</a>
                    <a href="{{ route('blog') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Blog</a>
                    <a href="{{ route('blog-detail') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Blog Details</a>
                    <a href="{{ route('faqs') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">FAQs</a>
                    <a href="{{ route('contact') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Contact</a>
                    <a href="{{ route('privacy-policy') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">Privacy Policy</a>
                    <a href="{{ route('error-404') }}"
                        class="block rounded-sm px-3 py-2 text-sm font-semibold text-default-800 hover:bg-primary/6 hover:text-primary"
                        tabindex="0">404</a>
                </div>
            </div>

            <a href="{{ route('services') }}"
                class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                <span
                    class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                Services
            </a>

            <a href="{{ route('contact') }}"
                class="group flex items-center px-2.5 py-4.5 text-base font-medium text-default-800 transition-all hover:text-primary">
                <span
                    class="me-1.25 mb-0.5 flex size-1.75 scale-0 bg-primary transition-all duration-300 group-hover:scale-100"></span>
                Contact
            </a>
        </div>
    </div>
</header>
