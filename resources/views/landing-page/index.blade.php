<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Surat Jalan Digital untuk PT Barraka Karya Mandiri">
    <meta name="theme-color" content="#3B82F6">
    <title>Sj BKM | Sistem Manajemen Surat Jalan Digital</title>

    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('images/logo.png') }}" as="image">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ... your existing styles ... */

        
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header class="fixed w-full bg-white/80 backdrop-blur-md shadow-sm z-50" x-data="{ isOpen: false }">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" loading="lazy" alt="Logo Sj BKM" class="h-12 w-auto">
                    <div>
                        <h1 class="text-xl font-bold gradient-text">Sj BKM</h1>
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
        <section id="hero"
            class="min-h-screen flex items-center bg-gradient-to-br from-green-50 to-indigo-50 relative overflow-hidden">

            {{-- Background Animation Elements --}}
            <div class="absolute inset-0 z-0">
                <div
                    class="absolute top-20 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
                </div>
                <div
                    class="absolute top-40 right-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
                </div>
            </div>

            {{-- Content Wrapper --}}
            <div class="container mx-auto px-4 py-16 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    {{-- Hero Content --}}
                    <div class="space-y-8" data-aos="fade-right">
                        <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                            <span class="block gradient-text">Sistem Manajemen</span>
                            <span class="block text-gray-600">Surat Jalan Digital</span>
                        </h1>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Platform manajemen surat jalan terpadu untuk PT Barraka Karya Mandiri. Kelola proses surat
                            jalan dari pembuatan hingga selesai dengan efisien.
                        </p>

                        {{-- Call-to-Action Buttons --}}
                        <div class="flex space-x-4">
                            <a href="#features" class="btn btn-primary group">
                                <span>Mulai Sekarang</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                            <a href="#process" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
                        </div>

                        {{-- Stats Section --}}
                        <div class="grid grid-cols-3 gap-8 pt-8">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600" data-counter="1000">0</div>
                                <div class="text-sm text-gray-600">Surat Jalan/Bulan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600" data-counter="50">0</div>
                                <div class="text-sm text-gray-600">Pengguna Aktif</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600" data-counter="99.9">0</div>
                                <div class="text-sm text-gray-600">% Akurasi</div>
                            </div>
                        </div>
                    </div>

                    {{-- 3D Model Viewer --}}
                    <div class="relative" data-aos="fade-left">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-400/10 to-indigo-400/10 rounded-3xl transform rotate-3">
                        </div>
                        <model-viewer src="{{ asset('images/models/container-loading-3D.glb') }}"
                            alt="3D Model of Container Loading" auto-rotate camera-controls shadow-intensity="1"
                            class="w-full h-[500px] rounded-2xl backdrop-blur-sm">
                            <div class="progress-bar hide" slot="progress-bar">
                                <div class="update-bar"></div>
                            </div>
                        </model-viewer>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </div>
        </section>

        {{-- sections/features.blade.php --}}
        <section id="features" class="py-20 bg-white relative">
            {{-- Background Pattern --}}
            <div
                class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] dark:bg-grid-slate-700/25 dark:[mask-image:linear-gradient(0deg,rgba(255,255,255,0.1),rgba(255,255,255,0.5))]">
            </div>

            <div class="container mx-auto px-4 relative z-10">
                {{-- Section Header --}}
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 gradient-text">Panel Sistem</h2>
                    <p class="text-xl text-green-600 mb-2">Sistem Terintegrasi yang Lengkap</p>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Setiap peran memiliki panel khusus dengan fitur yang disesuaikan untuk efisiensi kerja maksimal.
                    </p>
                </div>

                {{-- Feature Cards Grid --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Admin Panel Card --}}
                    <div class="feature-card group" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-green-100 rounded-full p-3 group-hover:bg-green-200 transition-colors">
                                <img src="{{ asset('images/gif/role/admin-icon.gif') }}" loading="lazy"
                                    alt="Admin Icon" class="w-12 h-12">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Panel Admin</h3>
                                <p class="text-gray-600">Kontrol penuh sistem</p>
                            </div>
                        </div>
                        <p class="text-gray-500">
                            Kontrol penuh sistem, manajemen pengguna, dan akses ke laporan dalam format PDF & Excel.
                        </p>
                        <ul class="mt-4 space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Manajemen User & Role
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Laporan Komprehensif
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Dashboard Analytics
                            </li>
                        </ul>
                    </div>

                    {{-- Client Panel Card --}}
                    <div class="feature-card group" data-aos="fade-up" data-aos-delay="200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-green-100 rounded-full p-3 group-hover:bg-green-200 transition-colors">
                                <img src="{{ asset('images/gif/role/client-icon.gif') }}" loading="lazy"
                                    alt="Client Icon" class="w-12 h-12">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Panel Client</h3>
                                <p class="text-gray-600">Monitoring pengiriman</p>
                            </div>
                        </div>
                        <p class="text-gray-500">
                            Akses laporan surat jalan khusus perusahaan Anda dalam format PDF.
                        </p>
                        <ul class="mt-4 space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Tracking Real-time
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Riwayat Pengiriman
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Download Laporan
                            </li>
                        </ul>
                    </div>

                    {{-- Field Officer Panel Card --}}
                    <div class="feature-card group" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-orange-100 rounded-full p-3 group-hover:bg-orange-200 transition-colors">
                                <img src="{{ asset('images/gif/role/field-icon.gif') }}" loading="lazy"
                                    alt="Field Officer Icon" class="w-12 h-12">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Panel Petugas Lapangan</h3>
                                <p class="text-gray-600">Pembuatan surat jalan</p>
                            </div>
                        </div>
                        <p class="text-gray-500">
                            Pembuatan surat jalan dan pengelolaan status "Dibuat" dengan antarmuka yang intuitif.
                        </p>
                        <ul class="mt-4 space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Input Data Cepat
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Validasi Otomatis
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Status Tracking
                            </li>
                        </ul>
                    </div>

                    {{-- Room Officer Panel Card --}}
                    <div class="feature-card group" data-aos="fade-up" data-aos-delay="400">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-purple-100 rounded-full p-3 group-hover:bg-purple-200 transition-colors">
                                <img src="{{ asset('images/gif/role/room-icon.gif') }}" loading="lazy"
                                    alt="Room Officer Icon" class="w-12 h-12">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Panel Petugas Ruangan</h3>
                                <p class="text-gray-600">Verifikasi & pencetakan</p>
                            </div>
                        </div>
                        <p class="text-gray-500">
                            Verifikasi dan pencetakan surat jalan dengan sistem yang efisien.
                        </p>
                        <ul class="mt-4 space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Verifikasi Digital
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Print Management
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approval System
                            </li>
                        </ul>
                    </div>

                    {{-- Warehouse Officer Panel Card --}}
                    <div class="feature-card group" data-aos="fade-up" data-aos-delay="500">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-red-100 rounded-full p-3 group-hover:bg-red-200 transition-colors">
                                <img src="{{ asset('images/gif/role/warehouse-icon.gif') }}" loading="lazy"
                                    alt="Warehouse Officer Icon" class="w-12 h-12">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Panel Petugas Gudang</h3>
                                <p class="text-gray-600">Manajemen gudang</p>
                            </div>
                        </div>
                        <p class="text-gray-500">
                            Pengelolaan status dari "Sampai" hingga "Selesai" dengan tracking real-time.
                        </p>
                        <ul class="mt-4 space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Status
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Inventory Control
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Real-time Tracking
                            </li>
                        </ul>
                    </div>

                    {{-- Developer Panel Card --}}
                    <div class="feature-card group" data-aos="fade-up" data-aos-delay="600">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-indigo-100 rounded-full p-3 group-hover:bg-indigo-200 transition-colors">
                                <img src="{{ asset('images/gif/role/developer-icon.gif') }}" loading="lazy"
                                    alt="Developer Icon" class="w-12 h-12">
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Panel Developer</h3>
                                <p class="text-gray-600">Pengembangan sistem</p>
                            </div>
                        </div>
                        <p class="text-gray-500">
                            Untuk Pembuatan Fitur baru yang menarik yang akan terus dikembangkan.
                        </p>
                        <ul class="mt-4 space-y-2">
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                API Integration
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                System Updates
                            </li>
                            <li class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Custom Features
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Process Section --}}
        <section id="process" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                {{-- Section Header --}}
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 gradient-text">Alur Kerja</h2>
                    <p class="text-xl text-green-600 mb-2">Proses Surat Jalan yang Terstruktur</p>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Pantau setiap tahap proses surat jalan dari awal hingga akhir dengan sistem yang terintegrasi.
                    </p>
                </div>

                {{-- Process Timeline --}}
                <div class="relative">
                    {{-- Timeline Line --}}
                    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-green-200"></div>

                    {{-- Timeline Items --}}
                    <div class="grid gap-8">
                        {{-- Step 1: Dibuat --}}
                        <div class="flex justify-center items-center" data-aos="fade-right">
                            <div class="w-1/2 pr-8 text-right">
                                <h3 class="text-xl font-bold text-gray-600">1. Dibuat</h3>
                                <p class="text-gray-600 mt-2">
                                    Petugas lapangan membuat surat jalan baru dengan input data yang akurat.
                                </p>
                            </div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-gray-600 rounded-full border-4 border-white shadow"></div>
                            </div>
                            <div class="w-1/2 pl-8">
                                <img src="{{ asset('images/gif/status/status-icon-1.gif') }}" loading="lazy"
                                    alt="Dibuat Icon" class="w-16 h-16">
                            </div>
                        </div>

                        {{-- Step 2: Dikirim --}}
                        <div class="flex justify-center items-center" data-aos="fade-left">
                            <div class="w-1/2 pr-8 text-right">
                                <img src="{{ asset('images/gif/status/status-icon-2.gif') }}" loading="lazy"
                                    alt="Dikirim Icon" class="w-16 h-16 ml-auto">
                            </div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-yellow-400 rounded-full border-4 border-white shadow"></div>
                            </div>
                            <div class="w-1/2 pl-8">
                                <h3 class="text-xl font-bold text-yellow-400">2. Dikirim</h3>
                                <p class="text-gray-600 mt-2">
                                    Verifikasi dan pengiriman oleh petugas ruangan dengan tracking status.
                                </p>
                            </div>
                        </div>

                        {{-- Step 3: Sampai --}}
                        <div class="flex justify-center items-center" data-aos="fade-right">
                            <div class="w-1/2 pr-8 text-right">
                                <h3 class="text-xl font-bold text-blue-500">3. Sampai</h3>
                                <p class="text-gray-600 mt-2">
                                    Konfirmasi penerimaan di gudang oleh petugas gudang dengan validasi.
                                </p>
                            </div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-blue-500 rounded-full border-4 border-white shadow"></div>
                            </div>
                            <div class="w-1/2 pl-8">
                                <img src="{{ asset('images/gif/status/status-icon-3.gif') }}" loading="lazy"
                                    alt="Sampai Icon" class="w-16 h-16">
                            </div>
                        </div>

                        {{-- Step 4: Selesai --}}
                        <div class="flex justify-center items-center" data-aos="fade-left">
                            <div class="w-1/2 pr-8 text-right">
                                <img src="{{ asset('images/gif/status/status-icon-4.gif') }}" loading="lazy"
                                    alt="Selesai Icon" class="w-16 h-16 ml-auto">
                            </div>
                            <div class="relative">
                                <div class="w-8 h-8 bg-green-500 rounded-full border-4 border-white shadow"></div>
                            </div>
                            <div class="w-1/2 pl-8">
                                <h3 class="text-xl font-bold text-green-500">4. Selesai</h3>
                                <p class="text-gray-600 mt-2">
                                    Proses bongkar muat telah selesai dengan efisien dan terdokumentasi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Testimonials Section --}}
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
                                <img src="{{ asset('images/gif/testimonial/testimonial-image-1.gif') }}"
                                    loading="lazy" alt="Testimoni Admin" class="w-16 h-16 rounded-full">
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
                                <img src="{{ asset('images/gif/testimonial/testimonial-image-2.gif') }}"
                                    loading="lazy" alt="Testimoni Petugas" class="w-16 h-16 rounded-full">
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
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="activeSlide = activeSlide === 1 ? 2 : 1"
                            class="absolute top-1/2 -right-12 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50 focus:outline-none">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tech Stack Section --}}
        <section id="tech-stack" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 gradient-text">Tech Stack</h2>
                    <p class="text-xl text-green-600 mb-2">Teknologi yang Kami Gunakan</p>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Kami menggunakan teknologi terdepan untuk membangun aplikasi yang andal dan efisien.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-8 tech-grid">
                    <div class="tech-item rounded-lg shadow-lg p-8 text-center hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="100">
                        <img src="{{ asset('images/tech/laravel.svg') }}" loading="lazy" alt="Laravel"
                            class="w-20 h-20 mx-auto mb-4">
                        <span class="block text-gray-700 font-bold">Laravel</span>
                        <span class="text-sm text-gray-500">Framework PHP</span>
                    </div>

                    <div class="tech-item rounded-lg shadow-lg p-8 text-center hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="200">
                        <img src="{{ asset('images/tech/filament.svg') }}" loading="lazy" alt="Filament"
                            class="w-20 h-20 mx-auto mb-4">
                        <span class="block text-gray-700 font-bold">Filament</span>
                        <span class="text-sm text-gray-500">Admin Panel</span>
                    </div>

                    <div class="tech-item rounded-lg shadow-lg p-8 text-center hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="300">
                        <img src="{{ asset('images/tech/tailwind.svg') }}" loading="lazy" alt="TailwindCSS"
                            class="w-20 h-20 mx-auto mb-4">
                        <span class="block text-gray-700 font-bold">TailwindCSS</span>
                        <span class="text-sm text-gray-500">CSS Framework</span>
                    </div>

                    <div class="tech-item rounded-lg shadow-lg p-8 text-center hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="400">
                        <img src="{{ asset('images/tech/alpine.svg') }}" loading="lazy" alt="Alpine.js"
                            class="w-20 h-20 mx-auto mb-4">
                        <span class="block text-gray-700 font-bold">Alpine.js</span>
                        <span class="text-sm text-gray-500">JavaScript Framework</span>
                    </div>

                    <div class="tech-item rounded-lg shadow-lg p-8 text-center hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="500">
                        <img src="{{ asset('images/tech/mysql.svg') }}" loading="lazy" alt="MySQL"
                            class="w-20 h-20 mx-auto mb-4">
                        <span class="block text-gray-700 font-bold">MySQL</span>
                        <span class="text-sm text-gray-500">Database</span>
                    </div>

                    <div class="tech-item rounded-lg shadow-lg p-8 text-center hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="600">
                        <img src="{{ asset('images/tech/vite.svg') }}" loading="lazy" alt="Vite"
                            class="w-20 h-20 mx-auto mb-4">
                        <span class="block text-gray-700 font-bold">Vite</span>
                        <span class="text-sm text-gray-500">Build Tool</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- FAQ Section --}}
        <section id="faq" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                {{-- Section Header --}}
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 gradient-text">FAQ</h2>
                    <p class="text-xl text-green-600 mb-2">Pertanyaan yang Sering Diajukan</p>
                </div>

                {{-- FAQ Accordion --}}
                <div class="max-w-3xl mx-auto" x-data="{ activeTab: null }">
                    {{-- FAQ Item 1 --}}
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                        <button
                            class="faq-question w-full flex justify-between items-center py-4 px-6 text-left bg-gray-100 rounded-lg focus:outline-none"
                            @click="activeTab = activeTab === 1 ? null : 1">
                            <h3 class="text-lg font-semibold">Bagaimana cara mendaftar?</h3>
                            <svg class="w-5 h-5 transform transition-transform duration-200"
                                :class="{ 'rotate-180': activeTab === 1 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeTab === 1" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="faq-answer bg-white px-6 py-4 rounded-lg shadow-inner mt-2">
                            <p class="text-gray-600">
                                Pendaftaran hanya dapat dilakukan melalui admin sistem. Silakan hubungi admin untuk
                                informasi lebih lanjut mengenai proses pendaftaran.
                            </p>
                        </div>
                    </div>

                    {{-- FAQ Item 2 --}}
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                        <button
                            class="faq-question w-full flex justify-between items-center py-4 px-6 text-left bg-gray-100 rounded-lg focus:outline-none"
                            @click="activeTab = activeTab === 2 ? null : 2">
                            <h3 class="text-lg font-semibold">Apakah data saya aman?</h3>
                            <svg class="w-5 h-5 transform transition-transform duration-200"
                                :class="{ 'rotate-180': activeTab === 2 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeTab === 2" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="faq-answer bg-white px-6 py-4 rounded-lg shadow-inner mt-2">
                            <p class="text-gray-600">
                                Ya, keamanan data adalah prioritas kami. Semua data disimpan dengan enkripsi dan hanya
                                dapat diakses oleh pengguna yang berwenang.
                            </p>
                        </div>
                    </div>

                    {{-- FAQ Item 3 --}}
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                        <button
                            class="faq-question w-full flex justify-between items-center py-4 px-6 text-left bg-gray-100 rounded-lg focus:outline-none"
                            @click="activeTab = activeTab === 3 ? null : 3">
                            <h3 class="text-lg font-semibold">Siapa yang dapat mengakses laporan?</h3>
                            <svg class="w-5 h-5 transform transition-transform duration-200"
                                :class="{ 'rotate-180': activeTab === 3 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeTab === 3" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="faq-answer bg-white px-6 py-4 rounded-lg shadow-inner mt-2">
                            <p class="text-gray-600">
                                Admin dan client memiliki akses ke fitur laporan. Admin dapat mengakses semua laporan,
                                sementara client hanya dapat melihat laporan terkait perusahaan mereka.
                            </p>
                        </div>
                    </div>

                    {{-- FAQ Item 4 --}}
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                        <button
                            class="faq-question w-full flex justify-between items-center py-4 px-6 text-left bg-gray-100 rounded-lg focus:outline-none"
                            @click="activeTab = activeTab === 4 ? null : 4">
                            <h3 class="text-lg font-semibold">Bagaimana jika terjadi kendala teknis?</h3>
                            <svg class="w-5 h-5 transform transition-transform duration-200"
                                :class="{ 'rotate-180': activeTab === 4 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="activeTab === 4" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="faq-answer bg-white px-6 py-4 rounded-lg shadow-inner mt-2">
                            <p class="text-gray-600">
                                Tim support kami siap membantu 24/7. Anda dapat menghubungi admin sistem atau
                                menggunakan fitur bantuan yang tersedia di dalam aplikasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Team Developer Section --}}
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
                                    class="absolute inset-0 bg-gradient-to-br from-green-400 to-indigo-500 opacity-90 rounded-l-2xl">
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
                                                <img src="{{ asset('images/svg/javascript.svg') }}"
                                                    alt="JavaScript Logo" class="h-4 w-4 mr-1">
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
                                                class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm flex items-center">
                                                <img src="{{ asset('images/svg/tailwind.svg') }}"
                                                    alt="TailwindCSS Logo" class="h-4 w-4 mr-1">
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
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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


        {{-- Call to Action Section --}}
        <section class="py-20 bg-gradient-to-br from-green-600 to-indigo-700 relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="8" height="8" patternUnits="userSpaceOnUse">
                            <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#grid)" />
                </svg>
            </div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="text-center text-white" data-aos="fade-up">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap untuk memulai?</h2>
                    <p class="text-xl text-green-100 mb-8">Bergabunglah dengan kami dan tingkatkan efisiensi manajemen
                        surat jalan Anda.</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#"
                            class="bg-white text-green-600 hover:bg-green-50 px-8 py-3 rounded-full font-semibold transition-all transform hover:scale-105">
                            Hubungi Admin
                        </a>
                        <a href="#features"
                            class="border-2 border-white text-white hover:bg-white hover:text-green-600 px-8 py-3 rounded-full font-semibold transition-all">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            {{-- Main Footer Content --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 py-16">
                {{-- Company Info --}}
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/logo.png') }}" loading="lazy" alt="Logo Sj BKM"
                            class="h-12 w-auto">
                        <div>
                            <h3 class="text-xl font-bold">Sj BKM</h3>
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
