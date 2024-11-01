<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SJM-BKM | Sistem Manajemen Surat Jalan Digital</title>
    @vite('resources/css/app.css')
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    <style>
        .hero-pattern {
            background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
            opacity: 0.1;
        }

        .gradient-text {
            background: linear-gradient(90deg, #41cf3c 0%, #1e6b07 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .status-line::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -50%;
            width: 100%;
            height: 2px;
            background: #3B82F6;
            transform: translateY(-50%);
        }

        /* Tambahkan ke CSS Anda */
        #hero,
        #features,
        #process,
        #testimonials,
        #tech-stack,
        #faq,
        #team {
            scroll-margin-top: 2rem;
            /* Sesuaikan dengan tinggi navbar */
        }

        @media (max-width: 768px) {
            .status-line::after {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-sm fixed w-full z-50 shadow-sm" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SJM-BKM" class="h-12 w-12">
                    <div>
                        <div class="text-2xl font-bold gradient-text">SJM-BKM</div>
                        <div class="text-sm text-gray-500">Digital Delivery System</div>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#hero"
                        class="text-gray-600 hover:text-green-600 transition-colors font-medium">Beranda</a>
                    <a href="#features"
                        class="text-gray-600 hover:text-green-600 transition-colors font-medium">Fitur</a>
                    <a href="#process"
                        class="text-gray-600 hover:text-green-600 transition-colors font-medium">Proses</a>
                    <a href="#testimonials"
                        class="text-gray-600 hover:text-green-600 transition-colors font-medium">Testimoni</a>
                    <a href="#tech-stack" class="text-gray-600 hover:text-green-600 transition-colors font-medium">Tech
                        Stack</a>
                    <a href="#faq" class="text-gray-600 hover:text-green-600 transition-colors font-medium">FAQ</a>
                    <a href="#team" class="text-gray-600 hover:text-green-600 transition-colors font-medium">Tim</a>

                    <div class="relative" x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                            class="inline-flex items-center px-4 py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white rounded-lg transition-colors">
                            <span>Login</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="isOpen" @click.away="isOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2">
                            <a href="/admin/login" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Admin
                                Login</a>
                            <a href="/client/login"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Client Login</a>
                            <a href="/field/login"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Petugas Lapangan</a>
                            <a href="/room/login"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Petugas Ruangan</a>
                            <a href="/warehouse/login"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50">Petugas Gudang</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open"
                        class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#hero"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Beranda</a>
                <a href="#features"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Fitur</a>
                <a href="#process"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Proses</a>
                <a href="#testimonials"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Testimoni</a>
                <a href="#tech-stack"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Tech
                    Stack</a>
                <a href="#faq"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">FAQ</a>
                <a href="#team"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Tim</a>

                <div class="px-3 py-2">
                    <span class="text-sm font-medium text-gray-500">Login Options</span>
                    <div class="mt-2 space-y-1">
                        <a href="/admin/login"
                            class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">Admin Login</a>
                        <a href="/client/login"
                            class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">Client Login</a>
                        <a href="/field/login"
                            class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">Petugas
                            Lapangan</a>
                        <a href="/room/login"
                            class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">Petugas
                            Ruangan</a>
                        <a href="/warehouse/login"
                            class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">Petugas
                            Gudang</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="hero" class="relative min-h-screen pt-20 overflow-hidden">
        <div class="hero-pattern absolute inset-0"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative pt-10 lg:pt-20">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                        <h1
                            class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                            <span class="block">Sistem Manajemen</span>
                            <span class="block gradient-text mt-1">Surat Jalan Digital</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                            Platform manajemen surat jalan terpadu untuk PT Barraka Karya Mandiri.
                            Kelola proses surat jalan dari pembuatan hingga selesai dengan efisien.
                        </p>
                        <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left">
                            <a href="#features"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors">
                                Mulai Sekarang
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div
                        class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                            <model-viewer src="{{ asset('images/models/Report-3D.glb') }}" alt="3D Model of Container"
                                auto-rotate camera-controls background-color="#ffffff"
                                style="width: 100%; height: 400px;">
                            </model-viewer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Panel Sistem</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Sistem Terintegrasi yang Lengkap
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Setiap peran memiliki panel khusus dengan fitur yang disesuaikan untuk efisiensi kerja maksimal.
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Admin Panel -->
                    <div class="relative group">
                        <div
                            class="h-full card-hover bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-12 w-12 bg-green-100 rounded-md flex items-center justify-center">
                                            <img src="{{ asset('images/Gif/role/admin-icon.gif') }}" alt="Admin Icon"
                                                class="h-8 w-8">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Panel Admin</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-base text-gray-500">
                                        Kontrol penuh sistem, manajemen pengguna, dan akses ke laporan dalam format PDF
                                        & Excel.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client Panel -->
                    <div class="relative group">
                        <div
                            class="h-full card-hover bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-12 w-12 bg-green-100 rounded-md flex items-center justify-center">
                                            <img src="{{ asset('images/Gif/role/client-icon.gif') }}"
                                                alt="Client Icon" class="h-8 w-8">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Panel Client</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-base text-gray-500">
                                        Akses laporan surat jalan khusus perusahaan Anda dalam format PDF.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field Officer Panel -->
                    <div class="relative group">
                        <div
                            class="h-full card-hover bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-12 w-12 bg-yellow-100 rounded-md flex items-center justify-center">
                                            <img src="{{ asset('images/Gif/role/field-icon.gif') }}"
                                                alt="Field Officer Icon" class="h-8 w-8">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Panel Petugas Lapangan</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-base text-gray-500">
                                        Pembuatan surat jalan dan pengelolaan status "Dibuat" dengan antarmuka yang
                                        intuitif.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Officer Panel -->
                    <div class="relative group">
                        <div
                            class="h-full card-hover bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-12 w-12 bg-purple-100 rounded-md flex items-center justify-center">
                                            <img src="{{ asset('images/Gif/role/room-icon.gif') }}"
                                                alt="Room Officer Icon" class="h-8 w-8">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Panel Petugas Ruangan</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-base text-gray-500">
                                        Verifikasi dan pencetakan surat jalan dengan sistem yang efisien.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Warehouse Officer Panel -->
                    <div class="relative group">
                        <div
                            class="h-full card-hover bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 bg-red-100 rounded-md flex items-center justify-center">
                                            <img src="{{ asset('images/Gif/role/warehouse-icon.gif') }}"
                                                alt="Warehouse Officer Icon" class="h-8 w-8">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Panel Petugas Gudang</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-base text-gray-500">
                                        Pengelolaan status dari "Sampai" hingga "Selesai" dengan tracking real-time.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Developer Panel -->
                    <div class="relative group">
                        <div
                            class="h-full card-hover bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 bg-blue-100 rounded-md flex items-center justify-center">
                                            <img src="{{ asset('images/Gif/role/developer-icon.gif') }}"
                                                alt="Developer Icon" class="h-8 w-8">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">Panel Developer</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-base text-gray-500">
                                        Untuk Pembuatan Fitur baru yang menarik yang akan terus dikembangkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div id="process" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Alur Kerja</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Proses Surat Jalan yang Terstruktur
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Pantau setiap tahap proses surat jalan dari awal hingga akhir
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Step 1: Dibuat -->
                    <div class="relative">
                        <div class="card-hover bg-white rounded-lg shadow-sm p-6 text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <img src="{{ asset('images/Gif/status/status-icon-1.gif') }}" alt="Dibuat Icon"
                                    class="h-10 w-10">
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">1. Dibuat</h3>
                            <p class="mt-2 text-sm text-gray-500">Petugas lapangan membuat surat jalan baru</p>
                            <div class="status-line hidden md:block"></div>
                        </div>
                    </div>

                    <!-- Step 2: Dikirim -->
                    <div class="relative">
                        <div class="card-hover bg-white rounded-lg shadow-sm p-6 text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <img src="{{ asset('images/Gif/status/status-icon-2.gif') }}" alt="Dikirim Icon"
                                    class="h-10 w-10">
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">2. Dikirim</h3>
                            <p class="mt-2 text-sm text-gray-500">Verifikasi dan pengiriman oleh petugas ruangan
                            </p>
                            <div class="status-line hidden md:block"></div>
                        </div>
                    </div>

                    <!-- Step 3: Sampai -->
                    <div class="relative">
                        <div class="card-hover bg-white rounded-lg shadow-sm p-6 text-center">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto">
                                <img src="{{ asset('images/Gif/status/status-icon-3.gif') }}" alt="Sampai Icon"
                                    class="h-10 w-10">
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">3. Sampai</h3>
                            <p class="mt-2 text-sm text-gray-500">Konfirmasi penerimaan di gudang
                                oleh petugas gudang
                            </p>
                            <div class="status-line hidden md:block"></div>
                        </div>
                    </div>

                    <!-- Step 4: Selesai -->
                    <div class="relative">
                        <div class="card-hover bg-white rounded-lg shadow-sm p-6 text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                                <img src="{{ asset('images/Gif/status/status-icon-4.gif') }}" alt="Selesai Icon"
                                    class="h-10 w-10">
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">4. Selesai</h3>
                            <p class="mt-2 text-sm text-gray-500">Proses bongkar muat telah selesai dengan efisien</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div id="testimonials" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Testimonial</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Apa Kata Pengguna Kami
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="card-hover bg-white rounded-xl shadow-sm p-8">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/Gif/testimonial/testimonial-image-1.gif') }}"
                                alt="Testimoni Admin" class="h-12 w-12 rounded-full">
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Admin PT Barraka</h4>
                                <p class="text-sm text-gray-500">System Administrator</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "Sistem ini sangat membantu dalam mengelola dan memantau seluruh proses surat jalan
                            dengan efisien!"
                        </p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="card-hover bg-white rounded-xl shadow-sm p-8">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/Gif/testimonial/testimonial-image-2.gif') }}"
                                alt="Testimoni Petugas" class="h-12 w-12 rounded-full">
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Petugas Lapangan</h4>
                                <p class="text-sm text-gray-500">Field Officer</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "Interface yang mudah digunakan dan sangat membantu pekerjaan di lapangan menjadi lebih
                            efisien."
                        </p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="card-hover bg-white rounded-xl shadow-sm p-8">
                        <div class="flex items-center mb-6">
                            <img src="{{ asset('images/Gif/testimonial/testimonial-image-3.gif') }}"
                                alt="Testimoni Gudang" class="h-12 w-12 rounded-full">
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Petugas Gudang</h4>
                                <p class="text-sm text-gray-500">Warehouse Staff</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">
                            "Tracking status pengiriman menjadi lebih mudah dan akurat dengan sistem ini."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tech Stack Section -->
    <div id="tech-stack" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Tech Stack</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Teknologi yang Kami Gunakan
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Kami menggunakan teknologi terdepan untuk membangun aplikasi yang andal dan efisien
                </p>
            </div>

            <div class="mt-16 grid grid-cols-2 gap-8 md:grid-cols-4">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <img src="{{ asset('images/tech/laravel.svg') }}" alt="Laravel" class="h-12 w-12 mx-auto mb-4">
                    <span class="text-lg font-medium text-gray-900">Laravel</span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <img src="{{ asset('images/tech/tailwind.svg') }}" alt="TailwindCSS"
                        class="h-12 w-12 mx-auto mb-4">
                    <span class="text-lg font-medium text-gray-900">TailwindCSS</span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <img src="{{ asset('images/tech/alpine.svg') }}" alt="Alpine.js" class="h-12 w-12 mx-auto mb-4">
                    <span class="text-lg font-medium text-gray-900">Alpine.js</span>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <img src="{{ asset('images/tech/mysql.svg') }}" alt="MySQL" class="h-12 w-12 mx-auto mb-4">
                    <span class="text-lg font-medium text-gray-900">MySQL</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div id="faq" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">FAQ</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Pertanyaan yang Sering Diajukan
                </p>
            </div>

            <div class="mt-12 max-w-3xl mx-auto">
                <div class="space-y-6">
                    <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm">
                        <button @click="open = !open"
                            class="w-full px-6 py-4 flex justify-between items-center focus:outline-none">
                            <h3 class="text-lg font-medium text-gray-900">Bagaimana cara mendaftar?</h3>
                            <svg class="h-6 w-6 text-gray-400" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="px-6 pb-4">
                            <p class="text-gray-600">Pendaftaran hanya dapat dilakukan melalui admin sistem.
                                Silakan hubungi admin untuk informasi lebih lanjut mengenai proses pendaftaran.</p>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm">
                        <button @click="open = !open"
                            class="w-full px-6 py-4 flex justify-between items-center focus:outline-none">
                            <h3 class="text-lg font-medium text-gray-900">Apakah data saya aman?</h3>
                            <svg class="h-6 w-6 text-gray-400" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="px-6 pb-4">
                            <p class="text-gray-600">Ya, keamanan data adalah prioritas kami. Semua data disimpan
                                dengan enkripsi dan hanya dapat diakses oleh pengguna yang berwenang.</p>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm">
                        <button @click="open = !open"
                            class="w-full px-6 py-4 flex justify-between items-center focus:outline-none">
                            <h3 class="text-lg font-medium text-gray-900">Siapa yang dapat mengakses laporan?</h3>
                            <svg class="h-6 w-6 text-gray-400" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="px-6 pb-4">
                            <p class="text-gray-600">Admin dan client memiliki akses ke fitur laporan. Admin dapat
                                mengakses semua laporan, sementara client hanya dapat melihat laporan terkait
                                perusahaan mereka.</p>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="bg-white rounded-lg shadow-sm">
                        <button @click="open = !open"
                            class="w-full px-6 py-4 flex justify-between items-center focus:outline-none">
                            <h3 class="text-lg font-medium text-gray-900">Bagaimana jika terjadi kendala teknis?
                            </h3>
                            <svg class="h-6 w-6 text-gray-400" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="px-6 pb-4">
                            <p class="text-gray-600">Tim support kami siap membantu 24/7. Anda dapat menghubungi
                                admin sistem atau menggunakan fitur bantuan yang tersedia di dalam aplikasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Developer Section -->
    <div id="team" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-green-600 font-semibold tracking-wide uppercase">Tim Pengembang</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Didukung oleh <img src="{{ asset('images/team/LogoDev.png') }}" alt="Artelia .DEV"
                        class="h-12 mx-auto">
                </p>
            </div>

            <!-- Developer Profile -->
            <div class="mt-12 max-w-sm mx-auto md:max-w-none md:flex md:justify-center">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden md:max-w-2xl md:flex">
                    <div class="p-8">
                        <div class="text-center md:text-left">
                            <h3 class="text-2xl font-bold text-gray-900">Denis Djodian Ardika</h3>
                            <p class="text-lg text-green-600 mt-1">Full Stack Developer</p>
                        </div>
                        <div class="mt-6 text-gray-500 text-base">
                            Seorang Full Stack Developer berdedikasi yang mengembangkan seluruh sistem SJM-BKM secara
                            mandiri, dengan keahlian dalam bahasa pemrograman PHP, Javascript, dan MySQL.
                        </div>
                        <!-- Social Links -->
                        <div class="mt-6 flex justify-center md:justify-start space-x-6">
                            <a href="https://www.instagram.com/artelia_development" target="_blank"
                                class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://github.com/denis156" target="_blank"
                                class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="mailto:denisdjodian2003@gmail.com" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Email</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-green-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Siap untuk memulai?</span>
                <span class="block text-green-200">Bergabung dengan kami sekarang.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="#"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-600 bg-white hover:bg-green-50">
                        Hubungi Admin
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#features"
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-700 hover:bg-green-800">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SJM-BKM" class="h-10 w-10">
                        <div>
                            <div class="text-xl font-bold text-white">SJM-BKM</div>
                            <div class="text-sm text-gray-400">Digital Delivery System</div>
                        </div>
                    </div>
                    <p class="text-gray-400 text-base">
                        Sistem manajemen surat jalan digital yang efisien dan terintegrasi untuk seluruh proses
                        pengiriman.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Solusi</h3>
                            <ul role="list" class="mt-4 space-y-4">
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">Surat Jalan
                                        Digital</a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">Manajemen
                                        Pengiriman</a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">Tracking
                                        Status</a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Support</h3>
                            <ul role="list" class="mt-4 space-y-4">
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">Bantuan</a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">Kontak</a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-gray-400 hover:text-white">FAQ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-400 text-center">
                    &copy; 2023 PT Barraka Karya Mandiri. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-8 right-8 bg-green-600 text-white p-2 rounded-full shadow-lg hidden hover:bg-green-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        // Initialize smooth-scroll library
        const scroll = new SmoothScroll('a[href*="#"]', {
            speed: 800,
            speedAsDuration: true,
            offset: 80
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 100) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Mobile Menu
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
