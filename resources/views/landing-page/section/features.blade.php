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
                        <img src="{{ asset('images/gif/role/admin-icon.gif') }}" loading="lazy" alt="Admin Icon"
                            class="w-12 h-12">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Manajemen User & Role
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Laporan Komprehensif
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Dashboard Analytics
                    </li>
                </ul>
            </div>

            {{-- Client Panel Card --}}
            <div class="feature-card group" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-green-100 rounded-full p-3 group-hover:bg-green-200 transition-colors">
                        <img src="{{ asset('images/gif/role/client-icon.gif') }}" loading="lazy" alt="Client Icon"
                            class="w-12 h-12">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Tracking Real-time
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Riwayat Pengiriman
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Download Laporan
                    </li>
                </ul>
            </div>

            {{-- Field Officer Panel Card --}}
            <div class="feature-card group" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-orange-100 rounded-full p-3 group-hover:bg-orange-200 transition-colors">
                        <img src="{{ asset('images/gif/role/field-icon.gif') }}" loading="lazy" alt="Field Officer Icon"
                            class="w-12 h-12">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Input Data Cepat
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Validasi Otomatis
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Verifikasi Digital
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Print Management
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Status
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Inventory Control
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Real-time Tracking
                    </li>
                </ul>
            </div>

            {{-- Developer Panel Card --}}
            <div class="feature-card group" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-green-100 rounded-full p-3 group-hover:bg-green-200 transition-colors">
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
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        API Integration
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        System Updates
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Custom Features
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
