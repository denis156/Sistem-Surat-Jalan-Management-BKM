<x-filament-panels::page>
    <div x-data="{
        checkOrientation() {
                return window.innerHeight > window.innerWidth;
            },
            isPortrait: false,
            init() {
                this.isPortrait = this.checkOrientation();
                window.addEventListener('resize', () => {
                    this.isPortrait = this.checkOrientation();
                });
            }
    }" x-init="init">
        <!-- Modal Orientasi -->
        <div x-show="isPortrait" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div
                class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl max-w-md mx-4 border border-gray-200 dark:border-gray-700">
                <div class="text-center space-y-6">
                    <!-- Animated GIF -->
                    <div class="relative mx-auto w-32 h-32 flex items-center justify-center mb-6">
                        <img src="{{ asset('images/svg/rotate-phone.svg') }}" alt="Rotate Phone Animation"
                            style="max-width: 100px; max-height: 100px;">
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Rotasi Layar Diperlukan
                    </h2>

                    <!-- Description -->
                    <div class="space-y-3">
                        <p class="text-gray-600 dark:text-gray-300">
                            Untuk tampilan surat jalan yang optimal, silakan putar perangkat Anda ke mode <span
                                class="font-semibold text-primary-600 dark:text-primary-400">landscape</span>
                            (horizontal).
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tip: Aktifkan rotasi otomatis pada perangkat Anda untuk pengalaman terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Area -->
        <div x-data="{ printDeliveryNote() { window.print(); } }" x-on:print-delivery-note.window="printDeliveryNote">
            <x-filament::card class="p-4 bg-white dark:bg-gray-900 text-black dark:text-white">
                <div id="printable-area" class="bg-white dark:bg-gray-900 text-black dark:text-white">
                    <!-- Header -->
                    <header class="flex justify-between items-center mb-4 relative">
                        <div class="flex items-center space-x-4">
                            <div class="company-logo">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan"
                                    style="width: 48px; height: 48px;">
                            </div>
                            <div class="company-info text-xs dark:text-white">
                                <h2 class="text-base font-bold">PT. BARAKKA KARYA MANDIRI</h2>
                                <p>Alamat: Kantor Pelindo Lantai 2, Jalan Kongoasa</p>
                                <p>No. 2 Kandai, Kota Kendari, Sulawesi Tenggara</p>
                            </div>
                        </div>
                        <div class="header-title absolute top-0 right-1/2 transform translate-x-1/2 text-right w-full">
                            <h2 class="text-lg font-bold underline dark:text-white">Surat Jalan</h2>
                        </div>
                    </header>

                    <!-- Tabel: Bill To, Ship To, dan Detail Pengiriman -->
                    <table class="w-full border-collapse text-xs mb-4 custom-table dark:text-white">
                        <tr>
                            <!-- Kolom kiri: Bill To dan Gudang Tujuan -->
                            <td class="w-1/2 p-4 align-top bg-white dark:bg-gray-800 text-black dark:text-white">
                                <div class="flex flex-col space-y-4">
                                    <div
                                        class="border border-black dark:border-gray-300 p-2 h-[50px] flex justify-between items-center custom-header">
                                        <p class="font-bold">Kepada:</p>
                                        <p>
                                            {{ $record->client->user->name ?? 'Tidak ada nama' }} -
                                            {{ $record->client->company_name ?? 'Tidak ada nama perusahaan' }}
                                        </p>
                                    </div>
                                    <div
                                        class="border border-black dark:border-gray-300 p-2 h-[50px] flex justify-between items-center custom-header">
                                        <p class="font-bold">Gudang Tujuan:</p>
                                        <p>{{ $record->ship_to ?? 'Belum ada tujuan' }}</p>
                                    </div>
                                </div>
                            </td>
                            <!-- Kolom kanan: Detail Pengiriman -->
                            <td class="w-1/2 p-4 align-top bg-white dark:bg-gray-800 text-black dark:text-white">
                                <div class="flex flex-col space-y-4">
                                    <div class="flex space-x-4">
                                        <div
                                            class="border border-black dark:border-gray-300 p-2 h-[50px] w-1/2 custom-header flex items-center">
                                            <p class="font-bold w-1/3 text-right mr-2">Tanggal Kirim:</p>
                                            <p class="w-2/3 text-left">
                                                {{ $record->tanggal_pengiriman ? $record->tanggal_pengiriman->format('d M Y') : 'Belum ada tanggal kirim' }}
                                            </p>
                                        </div>
                                        <div
                                            class="border border-black dark:border-gray-300 p-2 h-[50px] w-1/2 custom-header flex items-center">
                                            <p class="font-bold w-1/3 text-right mr-2">No. Surat:</p>
                                            <p class="w-2/3 text-left">
                                                {{ $record->nomor_surat ?? 'Belum ada nomor surat' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-4">
                                        <div
                                            class="border border-black dark:border-gray-300 p-2 h-[50px] w-1/2 custom-header flex items-center">
                                            <p class="font-bold w-1/3 text-right mr-2">No. Plat:</p>
                                            <p class="w-2/3 text-left">
                                                {{ $record->nomor_plat ?? 'Belum ada nomor plat' }}
                                            </p>
                                        </div>
                                        <div
                                            class="border border-black dark:border-gray-300 p-2 h-[50px] w-1/2 custom-header flex items-center">
                                            <p class="font-bold w-1/3 text-right mr-2">Supir:</p>
                                            <p class="w-2/3 text-left">
                                                {{ $record->nama_driver ?? 'Belum ada nama supir' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <!-- Tabel Item -->
                    <table
                        class="w-full border-collapse border border-black dark:border-gray-300 text-xs mb-6 custom-table dark:text-white">
                        <thead>
                            <tr>
                                <th
                                    class="border border-black dark:border-gray-300 p-2 w-1/12 bg-white dark:bg-gray-800">
                                    NO.</th>
                                <th
                                    class="border border-black dark:border-gray-300 p-2 w-5/12 bg-white dark:bg-gray-800">
                                    DESKRIPSI BARANG</th>
                                <th
                                    class="border border-black dark:border-gray-300 p-2 w-2/12 bg-white dark:bg-gray-800">
                                    QTY</th>
                                <th
                                    class="border border-black dark:border-gray-300 p-2 w-3/12 bg-white dark:bg-gray-800">
                                    Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @foreach ($record->items as $index => $item)
                                <tr>
                                    <td class="border border-black dark:border-gray-300 p-2 text-center">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="border border-black dark:border-gray-300 p-2">
                                        {{ $item->name_item ?? 'Tidak ada data' }}</td>
                                    <td class="border border-black dark:border-gray-300 p-2 text-center">
                                        {{ $item->quantity ?? 'Tidak ada data' }}</td>
                                    <td class="border border-black dark:border-gray-300 p-2">
                                        {{ $item->description ?? 'Tidak ada data' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tanda Tangan -->
                    <div class="flex justify-between text-xs mt-8 space-x-8">
                        <div class="custom-signature text-center mb-8">
                            <p>Di buat oleh,</p>
                            <div class="mt-8 border-t border-black dark:border-gray-300"></div>
                            <p>{{ $record->fieldOfficer->user->name ?? 'Belum ada petugas lapangan' }}</p>
                        </div>
                        <div class="custom-signature text-center mb-8">
                            <p>Disetujui Oleh</p>
                            <div class="mt-8 border-t border-black dark:border-gray-300"></div>
                            <p>{{ $record->roomOfficer->user->name ?? 'Belum ada petugas ruangan' }}</p>
                        </div>
                        <div class="custom-signature text-center mb-8">
                            <p>Supir</p>
                            <div class="mt-8 border-t border-black dark:border-gray-300"></div>
                            <p>{{ $record->nama_driver ?? 'Belum ada nama supir' }}</p>
                        </div>
                        <div class="custom-signature text-center mb-8">
                            <p>Penerima</p>
                            <div class="mt-8 border-t border-black dark:border-gray-300"></div>
                            <p>{{ $record->roomOfficer->user->name ?? 'Belum ada petugas gudang' }}</p>
                        </div>
                    </div>
                </div>
            </x-filament::card>
        </div>

        @push('styles')
            <style>
                .custom-table td,
                .custom-table th {
                    border: 1px solid black;
                    padding: 6px;
                    text-align: center;
                }

                .custom-signature {
                    width: 23%;
                    margin-bottom: 16px;
                }

                .custom-header {
                    border: 1px solid black;
                    padding: 6px;
                    height: 50px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .header-title {
                    position: absolute;
                    top: 0;
                    right: 50%;
                    transform: translateX(50%);
                    text-align: right;
                    width: 100%;
                }

                /* Backdrop blur effect */
                .backdrop-blur-sm {
                    backdrop-filter: blur(4px);
                    -webkit-backdrop-filter: blur(4px);
                }

                /* Style Cetak */
                @media print {
                    @page {
                        size: A4;
                        margin: 1mm 2mm 8mm 2mm;
                        /* Atas 1mm, Kanan 2mm, Bawah 8mm, Kiri 2mm */
                    }

                    body {
                        visibility: hidden;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }

                    #printable-area {
                        visibility: visible;
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                    }

                    /* Menempatkan footer tanggal di bawah halaman */
                    .print-date {
                        position: fixed;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        padding: 10px;
                        text-align: center;
                        font-size: 10px;
                    }

                    /* Sembunyikan modal saat mencetak */
                    [x-show="isPortrait"] {
                        display: none !important;
                    }
                }
            </style>
        @endpush

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.addEventListener('orientationchange', function() {
                        Alpine.nextTick(() => {
                            const alpineComponent = document.querySelector('[x-data]').__x;
                            if (alpineComponent) {
                                alpineComponent.$data.isPortrait = window.innerHeight > window.innerWidth;
                            }
                        });
                    });
                });
            </script>
        @endpush
</x-filament-panels::page>
