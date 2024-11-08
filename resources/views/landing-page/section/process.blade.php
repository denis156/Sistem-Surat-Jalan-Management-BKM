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
                        <img src="{{ asset('images/gif/status/status-icon-1.gif') }}" loading="lazy" alt="Dibuat Icon"
                            class="w-16 h-16">
                    </div>
                </div>

                {{-- Step 2: Dikirim --}}
                <div class="flex justify-center items-center" data-aos="fade-left">
                    <div class="w-1/2 pr-8 text-right">
                        <img src="{{ asset('images/gif/status/status-icon-2.gif') }}" loading="lazy" alt="Dikirim Icon"
                            class="w-16 h-16 ml-auto">
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
                        <img src="{{ asset('images/gif/status/status-icon-3.gif') }}" loading="lazy" alt="Sampai Icon"
                            class="w-16 h-16">
                    </div>
                </div>

                {{-- Step 4: Selesai --}}
                <div class="flex justify-center items-center" data-aos="fade-left">
                    <div class="w-1/2 pr-8 text-right">
                        <img src="{{ asset('images/gif/status/status-icon-4.gif') }}" loading="lazy" alt="Selesai Icon"
                            class="w-16 h-16 ml-auto">
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
