<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Surat Jalan Digital untuk PT Barraka Karya Mandiri">
    <meta name="theme-color" content="#3B82F6">
    <title>SJ BKM | Sistem Manajemen Surat Jalan Digital</title>

    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('images/logo.png') }}" as="image">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header class="fixed w-full bg-white/80 backdrop-blur-md shadow-sm z-50" x-data="{ isOpen: false }">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" loading="lazy" alt="Logo SJ BKM" class="h-12 w-auto">
                    <div>
                        <h1 class="text-xl font-bold gradient-text">SJ BKM</h1>
                        <p class="text-sm text-gray-600">Digital Delivery System</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#hero" class="text-gray-700 hover:text-green-600 transition-colors">Beranda</a>
                    <a href="#features" class="text-gray-700 hover:text-green-600 transition-colors">Fitur</a>
                    <a href="#process" class="text-gray-700 hover:text-green-600 transition-colors">Proses</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-green-600 transition-colors">Testimoni</a>
                    <a href="#tech-stack" class="text-gray-700 hover:text-green-600 transition-colors">Tech Stack</a>
                    <a href="#faq" class="text-gray-700 hover:text-green-600 transition-colors">FAQ</a>
                    <a href="#team" class="text-gray-700 hover:text-green-600 transition-colors">Tim</a>

                    <div class="relative" x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                            class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition-colors flex items-center space-x-2">
                            <span>Login</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="isOpen" @click.away="isOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <a href="/admin/login" class="block px-4 py-2 text-gray-800 hover:bg-green-50">Admin
                                Login</a>
                            <a href="/client/login" class="block px-4 py-2 text-gray-800 hover:bg-green-50">Client
                                Login</a>
                            <a href="/field/login" class="block px-4 py-2 text-gray-800 hover:bg-green-50">Petugas
                                Lapangan</a>
                            <a href="/room/login" class="block px-4 py-2 text-gray-800 hover:bg-green-50">Petugas
                                Ruangan</a>
                            <a href="/warehouse/login" class="block px-4 py-2 text-gray-800 hover:bg-green-50">Petugas
                                Gudang</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button @click="isOpen = !isOpen" class="text-gray-500 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4" class="lg:hidden mt-4">
                <div class="flex flex-col space-y-4">
                    <a href="#hero" class="text-gray-700 hover:text-green-600">Beranda</a>
                    <a href="#features" class="text-gray-700 hover:text-green-600">Fitur</a>
                    <a href="#process" class="text-gray-700 hover:text-green-600">Proses</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-green-600">Testimoni</a>
                    <a href="#tech-stack" class="text-gray-700 hover:text-green-600">Tech Stack</a>
                    <a href="#faq" class="text-gray-700 hover:text-green-600">FAQ</a>
                    <a href="#team" class="text-gray-700 hover:text-green-600">Tim</a>
                    <div class="pt-4 border-t border-gray-200">
                        <a href="/admin/login" class="block py-2 text-gray-700 hover:text-green-600">Admin Login</a>
                        <a href="/client/login" class="block py-2 text-gray-700 hover:text-green-600">Client Login</a>
                        <a href="/field/login" class="block py-2 text-gray-700 hover:text-green-600">Petugas
                            Lapangan</a>
                        <a href="/room/login" class="block py-2 text-gray-700 hover:text-green-600">Petugas Ruangan</a>
                        <a href="/warehouse/login" class="block py-2 text-gray-700 hover:text-green-600">Petugas
                            Gudang</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="pt-19">
        {{-- Hero Section --}}
        @include('landing-page.section.hero')

        {{-- sections features --}}
        @include('landing-page.section.features')

        {{-- Process Section --}}
        @include('landing-page.section.process')

        {{-- Testimonials Section --}}
        @include('landing-page.section.testimonials')

        {{-- Tech Stack Section --}}
        @include('landing-page.section.tech-stack')

        {{-- FAQ Section --}}
        @include('landing-page.section.faq')

        {{-- Team Developer Section --}}
        @include('landing-page.section.team')


        {{-- Call to Action Section --}}
        @include('landing-page.section.call-to-action')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            {{-- Main Footer Content --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 py-16">
                {{-- Company Info --}}
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/logo.png') }}" loading="lazy" alt="Logo SJ BKM"
                            class="h-12 w-auto">
                        <div>
                            <h3 class="text-xl font-bold">SJ BKM</h3>
                            <p class="text-gray-400">Digital Delivery System</p>
                        </div>
                    </div>
                    <p class="text-gray-400">
                        Sistem manajemen surat jalan digital yang efisien dan terintegrasi untuk seluruh proses
                        pengiriman.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Solutions Column --}}
                <div>
                    <h4 class="text-lg font-semibold mb-4">Solusi</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Surat Jalan Digital
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Manajemen Pengiriman
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Tracking Status
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Laporan Real-time
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Integrasi Sistem
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Support Column --}}
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Bantuan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Kontak
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                FAQ
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Dokumentasi
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                Status Sistem
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-400">
                                KANTOR PELINDO, 2ND FLOOR, JL. KONGGOASA NO. 2
                            </span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:info@sjbkm.id" class="text-gray-400 hover:text-white transition-colors">
                                info@sjbkm.id
                            </a>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:+6221234567890" class="text-gray-400 hover:text-white transition-colors">
                                +62 21 234 567 890
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Footer Bottom --}}
            <div class="border-t border-gray-800 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} PT Barraka Karya Mandiri. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                            Kebijakan Privasi
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                            Syarat & Ketentuan
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                            Peta Situs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Back to Top Button --}}
    <button id="backToTop"
        class="fixed bottom-8 right-8 bg-green-600 text-white p-3 rounded-full shadow-lg hover:bg-green-700 transition-all duration-200 opacity-0 invisible"
        x-data="{ isVisible: false }" x-show="isVisible" x-on:scroll.window="isVisible = (window.pageYOffset > 400)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

</body>

</html>
