<section id="team" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4 gradient-text">Tim Pengembang</h2>
            <div class="flex items-center justify-center space-x-3">
                <p class="text-xl text-green-600">Didukung oleh</p>
                <div class="logo-container">
                    <img src="{{ asset('images/team/LogoDev.png') }}" loading="lazy" alt="Artelia .DEV"
                        class="logo-image">
                </div>
            </div>
        </div>

        {{-- Developer Profile --}}
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden"
                data-aos="zoom-in">
                <div class="md:flex">
                    {{-- Profile Image --}}
                    <div class="md:w-1/3 relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-500 opacity-90 rounded-l-2xl">
                        </div>
                        <img src="{{ asset('images/team/developer-profile.jpg') }}" loading="lazy"
                            alt="Developer Profile" class="w-full h-full object-cover rounded-l-2xl">
                    </div>

                    {{-- Profile Info --}}
                    <div class="md:w-2/3 p-8">
                        <div class="mb-6">
                            <h3 class="text-2xl font-bold text-gray-800">Denis Djodian Ardika</h3>
                            <p class="text-green-600 font-medium">Full Stack Developer</p>
                        </div>

                        <p class="text-gray-600 leading-relaxed mb-6">
                            Seorang Full Stack Developer berdedikasi yang mengembangkan seluruh sistem Sj BKM
                            secara mandiri, dengan keahlian dalam bahasa pemrograman PHP, JavaScript, dan MySQL.
                        </p>

                        {{-- Skills --}}
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Skills:</h4>

                            {{-- Programming Languages --}}
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-600 mb-2">Bahasa Pemrograman:</h5>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 bg-green-300 text-green-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/python.svg') }}" alt="Python Logo"
                                            class="h-4 w-4 mr-1">
                                        Python
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/php.svg') }}" alt="PHP Logo"
                                            class="h-4 w-4 mr-1">
                                        PHP
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/javascript.svg') }}" alt="JavaScript Logo"
                                            class="h-4 w-4 mr-1">
                                        JavaScript
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/mysql.svg') }}" alt="MySQL Logo"
                                            class="h-4 w-4 mr-1">
                                        MySQL
                                    </span>
                                </div>
                            </div>

                            {{-- Frameworks --}}
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-600 mb-2">Framework:</h5>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 bg-red-300 text-red-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/laravel.svg') }}" alt="Laravel Logo"
                                            class="h-4 w-4 mr-1">
                                        Laravel
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-green-300 text-green-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/django.svg') }}" alt="Django Logo"
                                            class="h-4 w-4 mr-1">
                                        Django
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-yellow-300 text-yellow-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/react.svg') }}" alt="React Logo"
                                            class="h-4 w-4 mr-1">
                                        React.js
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/tailwind.svg') }}" alt="TailwindCSS Logo"
                                            class="h-4 w-4 mr-1">
                                        TailwindCSS
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-yellow-200 text-yellow-700 rounded-full text-sm flex items-center">
                                        <img src="{{ asset('images/svg/vite.svg') }}" alt="Vite Logo"
                                            class="h-4 w-4 mr-1">
                                        Vite.js
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Social Links --}}
                        <div class="flex space-x-4">
                            <a href="https://www.instagram.com/artelia_development" target="_blank"
                                class="social-link flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-green-500 hover:text-green-500 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                                <span>Instagram</span>
                            </a>
                            <a href="https://github.com/denis156" target="_blank"
                                class="social-link flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-gray-700 hover:text-gray-700 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                                <span>GitHub</span>
                            </a>
                            <a href="mailto:denisdjodian2003@gmail.com"
                                class="social-link flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg hover:border-red-500 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Email</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
