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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
