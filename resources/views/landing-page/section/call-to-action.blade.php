<section class="py-20 bg-gradient-to-br from-green-600 to-blue-700 relative overflow-hidden">
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
