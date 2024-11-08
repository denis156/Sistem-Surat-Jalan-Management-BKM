<section id="testimonials" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4 gradient-text">Testimonial</h2>
            <p class="text-xl text-green-600 mb-2">Apa Kata Pengguna Kami</p>
        </div>

        {{-- Testimonials Carousel --}}
        <div class="relative max-w-5xl mx-auto" x-data="{ activeSlide: 1 }">
            <div class="relative overflow-hidden">
                {{-- Testimonial 1 --}}
                <div class="testimonial-card" x-show="activeSlide === 1"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-full">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="{{ asset('images/gif/testimonial/testimonial-image-1.gif') }}" loading="lazy"
                            alt="Testimoni Admin" class="w-16 h-16 rounded-full">
                        <div>
                            <h4 class="text-xl font-semibold">Admin PT Barraka</h4>
                            <p class="text-gray-600">System Administrator</p>
                        </div>
                    </div>
                    <div class="relative">
                        <svg class="absolute -top-4 -left-4 w-8 h-8 text-green-200" fill="currentColor"
                            viewBox="0 0 32 32">
                            <path
                                d="M10 8c-2.2 0-4 1.8-4 4v12h8V12h-6c0-1.1 0.9-2 2-2V8zm12 0c-2.2 0-4 1.8-4 4v12h8V12h-6c0-1.1 0.9-2 2-2V8z" />
                        </svg>
                        <p class="text-gray-600 text-lg leading-relaxed pl-8">
                            "Sistem ini sangat membantu dalam mengelola dan memantau seluruh proses surat jalan
                            dengan efisien! Dashboard yang intuitif membuat monitoring menjadi lebih mudah."
                        </p>
                    </div>
                    <div class="mt-6 flex items-center">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-gray-500 ml-3">5.0 / 5.0</span>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div class="testimonial-card" x-show="activeSlide === 2"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-full">
                    <div class="flex items-center space-x-4 mb-6">
                        <img src="{{ asset('images/gif/testimonial/testimonial-image-2.gif') }}" loading="lazy"
                            alt="Testimoni Petugas" class="w-16 h-16 rounded-full">
                        <div>
                            <h4 class="text-xl font-semibold">Petugas Lapangan</h4>
                            <p class="text-gray-600">Field Officer</p>
                        </div>
                    </div>
                    <div class="relative">
                        <svg class="absolute -top-4 -left-4 w-8 h-8 text-green-200" fill="currentColor"
                            viewBox="0 0 32 32">
                            <path
                                d="M10 8c-2.2 0-4 1.8-4 4v12h8V12h-6c0-1.1 0.9-2 2-2V8zm12 0c-2.2 0-4 1.8-4 4v12h8V12h-6c0-1.1 0.9-2 2-2V8z" />
                        </svg>
                        <p class="text-gray-600 text-lg leading-relaxed pl-8">
                            "Interface yang mudah digunakan dan sangat membantu pekerjaan di lapangan menjadi
                            lebih efisien. Proses pembuatan surat jalan menjadi jauh lebih cepat."
                        </p>
                    </div>
                    <div class="mt-6 flex items-center">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <!-- Repeat for 4.5 stars -->
                        </div>
                        <span class="text-gray-500 ml-3">4.5 / 5.0</span>
                    </div>
                </div>

                {{-- Testimonial Navigation --}}
                <div class="absolute -bottom-10 left-0 right-0 flex justify-center space-x-2">
                    <button @click="activeSlide = 1"
                        :class="{ 'bg-green-600': activeSlide === 1, 'bg-gray-300': activeSlide !== 1 }"
                        class="w-3 h-3 rounded-full focus:outline-none transition-colors duration-200"></button>
                    <button @click="activeSlide = 2"
                        :class="{ 'bg-green-600': activeSlide === 2, 'bg-gray-300': activeSlide !== 2 }"
                        class="w-3 h-3 rounded-full focus:outline-none transition-colors duration-200"></button>
                    <!-- Add more buttons for additional testimonials -->
                </div>

                {{-- Navigation Arrows --}}
                <button @click="activeSlide = activeSlide === 1 ? 2 : 1"
                    class="absolute top-1/2 -left-12 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 focus:outline-none">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button @click="activeSlide = activeSlide === 1 ? 2 : 1"
                    class="absolute top-1/2 -right-12 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 focus:outline-none">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
