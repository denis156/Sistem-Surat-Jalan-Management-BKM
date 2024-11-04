<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Surat Jalan PT. Barraka Karya Mandiri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
            background-color: #f0f2f5;
        }

        .company-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 15px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #f3f4f6;
            padding: 8px;
            margin-bottom: 10px;
            font-weight: bold;
            border-radius: 4px;
        }

        .grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .grid-row {
            display: table-row;
        }

        .grid-cell {
            display: table-cell;
            padding: 6px;
            border: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: #dc2626;
        }

        .text-info {
            color: #2563eb;
        }

        .text-success {
            color: #059669;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 10px;
        }

        .table th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #059669;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #d97706;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .badge-info {
            background-color: #dbeafe;
            color: #3b82f6;
        }

        .badge-gray {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-after: always;
        }

        @page {
            margin: 0;
        }
    </style>
</head>

<body>
    <!-- Header dengan Logo -->
    <div class="company-header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo Perusahaan" class="logo"
            style="width: 80px; height: auto;">
        <div class="company-name">PT. BARRAKA KARYA MANDIRI</div>
        <h2 style="margin: 10px 0;">Laporan Surat Jalan</h2>

        <!-- Menggunakan tanggal dari filter -->
        <p style="margin: 5px 0;">
            Tanggal:
            {{ $filter['start_date'] ? \Carbon\Carbon::parse($filter['start_date'])->format('d M Y') : 'Awal' }} -
            {{ $filter['end_date'] ? \Carbon\Carbon::parse($filter['end_date'])->format('d M Y') : 'Akhir' }}
        </p>

        <!-- Menambahkan status dan tujuan jika ada dalam filter -->
        @if (!empty($filter['status']))
            <p>Status: {{ implode(', ', $filter['status']) }}</p>
        @endif
        @if (!empty($filter['ship_to']))
            <p>Tujuan: {{ implode(', ', $filter['ship_to']) }}</p>
        @endif
    </div>


    <!-- Card Daftar Surat Jalan -->
    <div class="card">
        <div class="card-header">
            <div class="section-title" style="margin:0;">Daftar Surat Jalan</div>
        </div>
        <div class="card-body">
            <!-- Tabel Informasi Dasar & Klien -->
            <table class="table" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="width: 3%;">No.</th>
                        <th style="width: 12%;">No. Surat</th>
                        <th style="width: 8%;">Status</th>
                        <th style="width: 5%;">Cetak</th>
                        <th style="width: 12%;">Nama PIC</th>
                        <th style="width: 12%;">Perusahaan</th>
                        <th style="width: 12%;">Tujuan</th>
                        <th style="width: 8%;">Supir</th>
                        <th style="width: 8%;">Plat</th>
                        <th style="width: 10%;">Tgl. Dibuat</th>
                        <th style="width: 10%;">Tgl. Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveryNotes as $index => $note)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $note->nomor_surat }}</strong></td>
                            <td class="text-center">
                                <span
                                    class="badge badge-{{ match ($note->status) {
                                        'dibuat' => 'gray',
                                        'dikirim' => 'warning',
                                        'sampai' => 'info',
                                        'selesai' => 'success',
                                        default => 'gray',
                                    } }}">
                                    {{ $note->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($note->print)
                                    <span class="badge badge-success">Sudah</span>
                                @else
                                    <span class="badge badge-danger">Belum</span>
                                @endif
                            </td>
                            <td>{{ $note->client->user->name ?? '-' }}</td>
                            <td>{{ $note->client->company_name ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge badge-{{ match ($note->ship_to) {
                                        'gudang kota' => 'success',
                                        'gudang unaaha' => 'warning',
                                        'gudang kolaka' => 'danger',
                                        default => 'gray',
                                    } }}">
                                    {{ $note->ship_to }}
                                </span>
                            </td>
                            <td>{{ $note->nama_driver }}</td>
                            <td>{{ $note->nomor_plat }}</td>
                            <td>{{ date('d/m/y H:i', strtotime($note->created_at)) }}</td>
                            <td>{{ $note->tanggal_bongkar ? date('d/m/y H:i', strtotime($note->tanggal_bongkar)) : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tabel Informasi Item -->
            <table class="table" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="width: 3%;">No.</th>
                        <th style="width: 12%;">No. Surat</th>
                        <th style="width: 30%;">Nama Item</th>
                        <th style="width: 10%;">Jumlah</th>
                        <th style="width: 35%;">Kondisi</th>
                        <th style="width: 10%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveryNotes as $index => $note)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $note->nomor_surat }}</td>
                            <td>
                                @foreach ($note->items as $item)
                                    • {{ $item->name_item }}<br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($note->items as $item)
                                    {{ $item->quantity }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($note->items as $item)
                                    {{ $item->description }}<br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">
                                    {{ collect($note->items)->sum(function ($item) {
                                        return $item->description === 'karung kurang' ? -$item->quantity : $item->quantity;
                                    }) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tabel Petugas -->
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 3%;">No.</th>
                        <th style="width: 12%;">No. Surat</th>
                        <th style="width: 25%;">Petugas Lapangan</th>
                        <th style="width: 25%;">Petugas Ruangan</th>
                        <th style="width: 25%;">Petugas Gudang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveryNotes as $index => $note)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $note->nomor_surat }}</td>
                            <td>{{ $note->fieldOfficer->user->name ?? '-' }}</td>
                            <td>{{ $note->roomOfficer->user->name ?? '-' }}</td>
                            <td>{{ $note->warehouseOfficer->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card Ringkasan -->
    <div class="card">
        <div class="card-header">
            <div class="section-title" style="margin:0;">Ringkasan Laporan Surat Jalan</div>
        </div>
        <div class="card-body">
            <!-- Informasi Gudang -->
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-cell text-center">
                        <strong>Gudang Kota:</strong><br>
                        {{ $summaryData['jumlah_gudang_kota'] }}
                    </div>
                    <div class="grid-cell text-center">
                        <strong>Gudang Unaaha:</strong><br>
                        {{ $summaryData['jumlah_gudang_unaaha'] }}
                    </div>
                    <div class="grid-cell text-center">
                        <strong>Gudang Kolaka:</strong><br>
                        {{ $summaryData['jumlah_gudang_kolaka'] }}
                    </div>
                    <div class="grid-cell text-center">
                        <strong>Total Surat Jalan:</strong><br>
                        {{ $summaryData['total_surat_jalan'] }}
                    </div>
                </div>
            </div>

            <!-- Kondisi Barang -->
            <div class="grid">
                <div class="grid-row">
                    <div class="grid-cell" colspan="2"><strong>Kapal</strong></div>
                    <div class="grid-cell" colspan="2"><strong>PBM</strong></div>
                    <div class="grid-cell" colspan="2"><strong>Truck</strong></div>
                </div>
                <div class="grid-row">
                    <div class="grid-cell text-center text-danger">Basah: {{ $summaryData['basah_kapal'] }}</div>
                    <div class="grid-cell text-center text-danger">Robek: {{ $summaryData['robek_kapal'] }}</div>
                    <div class="grid-cell text-center text-danger">Basah: {{ $summaryData['basah_pbm'] }}</div>
                    <div class="grid-cell text-center text-danger">Robek: {{ $summaryData['robek_pbm'] }}</div>
                    <div class="grid-cell text-center text-danger">Basah: {{ $summaryData['basah_truck'] }}</div>
                    <div class="grid-cell text-center text-danger">Robek: {{ $summaryData['robek_truck'] }}</div>
                </div>
            </div>

            <!-- Total -->
            <div class="grid" style="margin-bottom:0;">
                <div class="grid-row">
                    <div class="grid-cell text-center">
                        <strong>UTUH:</strong>
                        <div class="text-success">{{ $summaryData['utuh'] }}</div>
                    </div>
                    <div class="grid-cell text-center">
                        <strong>Karung Lebih:</strong>
                        <div class="text-info">{{ $summaryData['karung_lebih'] }}</div>
                    </div>
                    <div class="grid-cell text-center">
                        <strong>Karung Kurang:</strong>
                        <div class="text-danger">{{ $summaryData['karung_kurang'] }}</div>
                    </div>
                    <div class="grid-cell text-center">
                        <strong>Total Item (tanpa karung kurang):</strong>
                        <div>{{ $summaryData['total_item'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p style="margin: 2px 0;">PT. Barraka Karya Mandiri</p>
        <p style="margin: 2px 0;">KANTOR PELINDO, 2ND FLOOR, JL. KONGGOASA NO. 2</p>
        {{-- <p style="margin: 2px 0;">Telp: (0402) 123456 | Email: info@barrakakarya.com</p> --}}
        <p style="margin: 2px 0;">Dokumen ini dicetak pada: {{ date('d M Y H:i:s') }}</p>
    </div>
</body>

</html>
