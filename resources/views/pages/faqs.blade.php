@extends('layouts.app')

@section('title', 'FAQs | Manufactt - Manufacturing Services Website TailwindCSS 4 Template')

@section('content')
<section class="overflow-hidden relative size-full lg:py-50 py-25">
        <div class="container relative z-10">
            <div class="text-center mb-17.5">
                <h1 class="lg:text-7xl md:text-[56px] text-[48px]">Frequently Asked Questions</h1>
            </div>

            <div class="lg:w-200 mx-auto">
                <div class="md:space-y-7.5 space-y-5">

                    <!-- FAQ 1 -->
                    <div class="hs-accordion bg-default-100 p-5 rounded-lg active">
                        <button class="hs-accordion-toggle w-full flex justify-between items-center gap-2.5 text-start">
                            <h3>What are common manufacturing processes ?</h3>

                            <div class="bg-primary text-white size-7.5 rounded-full flex items-center justify-center">
                                <i class="iconify tabler--plus size-5 transition-transform duration-500 hs-accordion-active:rotate-45"></i>
                            </div>
                        </button>

                        <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 text-start">
                            <p class="mt-5">
                                The most common manufacturing processes include CNC machining, injection molding, 3D printing (additive manufacturing), sheet metal fabrication, casting, and automated assembly.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="hs-accordion bg-default-100 p-5 rounded-lg">
                        <button class="hs-accordion-toggle w-full flex justify-between items-center gap-2.5 text-start">
                            <h3>How does automation improve manufacturing ?</h3>

                            <div class="bg-primary text-white size-7.5 rounded-full flex items-center justify-center">
                                <i class="iconify tabler--plus size-5 transition-transform duration-500 hs-accordion-active:rotate-45"></i>
                            </div>
                        </button>

                        <div class="hs-accordion-content w-full hidden overflow-hidden transition-[height] duration-300 text-start">
                            <p class="mt-5">
                                Automation increases production speed, consistency, and accuracy while reducing human error. It also improves safety, lowers costs, and allows manufacturers to scale production without compromising quality.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="hs-accordion bg-default-100 p-5 rounded-lg">
                        <button class="hs-accordion-toggle w-full flex justify-between items-center gap-2.5 text-start">
                            <h3>Why is quality control important ?</h3>

                            <div class="bg-primary text-white size-7.5 rounded-full flex items-center justify-center">
                                <i class="iconify tabler--plus size-5 transition-transform duration-500 hs-accordion-active:rotate-45"></i>
                            </div>
                        </button>

                        <div class="hs-accordion-content w-full hidden overflow-hidden transition-[height] duration-300 text-start">
                            <p class="mt-5">
                                Quality control ensures products meet industry standards and customer requirements through inspections, testing, and monitoring. It helps minimize defects, reduce waste, and maintain product reliability.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="hs-accordion bg-default-100 p-5 rounded-lg">
                        <button class="hs-accordion-toggle w-full flex justify-between items-center gap-2.5 text-start">
                            <h3>How are materials chosen ?</h3>

                            <div class="bg-primary text-white size-7.5 rounded-full flex items-center justify-center">
                                <i class="iconify tabler--plus size-5 transition-transform duration-500 hs-accordion-active:rotate-45"></i>
                            </div>
                        </button>

                        <div class="hs-accordion-content w-full hidden overflow-hidden transition-[height] duration-300 text-start">
                            <p class="mt-5">
                                Material selection depends on mechanical properties, durability, cost, environmental factors, and compatibility with the production process. Advanced manufacturing often uses lightweight metals, composites, or polymers to improve performance.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="hs-accordion bg-default-100 p-5 rounded-lg">
                        <button class="hs-accordion-toggle w-full flex justify-between items-center gap-2.5 text-start">
                            <h3>What are the latest trends in manufacturing technology ?</h3>

                            <div class="bg-primary text-white size-7.5 rounded-full flex items-center justify-center">
                                <i class="iconify tabler--plus size-5 transition-transform duration-500 hs-accordion-active:rotate-45"></i>
                            </div>
                        </button>

                        <div class="hs-accordion-content w-full hidden overflow-hidden transition-[height] duration-300 text-start">
                            <p class="mt-5">
                                Key trends include additive manufacturing (3D printing), smart factories with IoT integration, AI-driven predictive maintenance, robotics, and sustainable manufacturing practices.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="hs-accordion bg-default-100 p-5 rounded-lg">
                        <button class="hs-accordion-toggle w-full flex justify-between items-center gap-2.5 text-start">
                            <h3>What challenges do manufacturers face today ?</h3>

                            <div class="bg-primary text-white size-7.5 rounded-full flex items-center justify-center">
                                <i class="iconify tabler--plus size-5 transition-transform duration-500 hs-accordion-active:rotate-45"></i>
                            </div>
                        </button>

                        <div class="hs-accordion-content w-full hidden overflow-hidden transition-[height] duration-300 text-start">
                            <p class="mt-5">
                                Manufacturers face rising material costs, labor shortages, and the need for skilled workers. Adopting automation, robotics, and AI requires investment, training, and operational changes.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>


    <!-- Footer -->
@endsection
