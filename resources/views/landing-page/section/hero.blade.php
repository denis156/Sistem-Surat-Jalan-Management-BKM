<section id="hero"
    class="min-h-screen flex items-center bg-gradient-to-br from-green-50 to-green-50 relative overflow-hidden">

    {{-- Background Animation Elements --}}
    <div class="absolute inset-0 z-0">
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-40 right-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
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
                            class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
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
                    class="absolute inset-0 bg-gradient-to-r from-green-400/10 to-green-400/10 rounded-3xl transform rotate-3">
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
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
        </svg>
    </div>
</section>
