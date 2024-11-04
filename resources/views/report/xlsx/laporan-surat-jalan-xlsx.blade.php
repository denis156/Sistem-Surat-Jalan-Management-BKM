<table>
    <!-- Judul Laporan -->
    <tr>
        <th colspan="17">
            LAPORAN SURAT JALAN PT. BARRAKA KARYA MANDIRI
            @if($filter['start_date'] && $filter['end_date'])
                ({{ \Carbon\Carbon::parse($filter['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($filter['end_date'])->format('d/m/Y') }})
            @elseif($filter['start_date'])
                (Dari {{ \Carbon\Carbon::parse($filter['start_date'])->format('d/m/Y') }})
            @elseif($filter['end_date'])
                (Sampai {{ \Carbon\Carbon::parse($filter['end_date'])->format('d/m/Y') }})
            @endif
        </th>
    </tr>

    <!-- Header Utama -->
    <tr>
        <th>No</th>
        <th>Nomor Surat</th>
        <th>Tanggal Pengiriman</th>
        <th>Bill To</th>
        <th>Ship To</th>
        <th>Nomor Plat</th>
        <th>Nama Driver</th>
        <th>Palka</th>
        <th>Status</th>
        <th>Tanggal Dibuat</th>
        <th>Tanggal Sampai</th>
        <th>Tanggal Bongkar</th>
        <th>Sudah Dicetak</th>
        <th>Petugas Lapangan</th>
        <th>Petugas Ruangan</th>
        <th>Petugas Gudang</th>
        <th>Updated At</th>
    </tr>

    <!-- Data Surat Jalan -->
    @foreach($deliveryNotes as $index => $note)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $note->nomor_surat }}</td>
        <td>{{ optional($note->tanggal_pengiriman)->format('d/m/Y H:i') ?: '-' }}</td>
        <td>{{ $note->client->user->name }}</td>
        <td>{{ $note->ship_to }}</td>
        <td>{{ $note->nomor_plat }}</td>
        <td>{{ $note->nama_driver }}</td>
        <td>{{ $note->palka }}</td>
        <td>{{ $note->status }}</td>
        <td>{{ $note->created_at->format('d/m/Y H:i') }}</td>
        <td>{{ optional($note->tanggal_sampai)->format('d/m/Y H:i') ?: '-' }}</td>
        <td>{{ optional($note->tanggal_bongkar)->format('d/m/Y H:i') ?: '-' }}</td>
        <td>{{ $note->print ? 'Ya' : 'Tidak' }}</td>
        <td>{{ $note->fieldOfficer->user->name ?? '-' }}</td>
        <td>{{ $note->roomOfficer->user->name ?? '-' }}</td>
        <td>{{ $note->warehouseOfficer->user->name ?? '-' }}</td>
        <td>{{ $note->updated_at->format('d/m/Y H:i') }}</td>
    </tr>

    <!-- Detail Item -->
    <tr>
        <th colspan="4">Detail Item</th>
    </tr>
    <tr>
        <th colspan="2">Nama Item</th>
        <th>Quantity</th>
        <th>Kondisi</th>
    </tr>
    @foreach($note->items as $item)
    <tr>
        <td colspan="2">{{ $item->name_item }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ $item->description }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2"></td>
        <td>TOTAL ITEM</td>
        <td>
            {{ $note->items->where('description', '!=', 'karung kurang')->sum('quantity') - ($note->items->where('description', 'karung kurang')->sum('quantity')) }}
        </td>
    </tr>
    <tr><td colspan="17"></td></tr>
    @endforeach

    <!-- Ringkasan -->
    <tr><td colspan="17"></td></tr>
    <tr>
        <th colspan="4">RINGKASAN GUDANG</th>
    </tr>
    <tr>
        <th>GUDANG KOTA</th>
        <th>GUDANG UNAAHA</th>
        <th>GUDANG KOLAKA</th>
        <th>TOTAL (Kesemua Gudang)</th>
    </tr>
    <tr>
        <td>{{ $summaryData['jumlah_gudang_kota'] ?? 0 }}</td>
        <td>{{ $summaryData['jumlah_gudang_unaaha'] ?? 0 }}</td>
        <td>{{ $summaryData['jumlah_gudang_kolaka'] ?? 0 }}</td>
        <td>{{ $summaryData['total_surat_jalan'] ?? 0 }}</td>
    </tr>

    <tr><td colspan="17"></td></tr>

    <tr>
        <th colspan="10">RINGKASAN KONDISI BARANG</th>
    </tr>
    <tr>
        <th>UTUH</th>
        <th>BASAH KAPAL</th>
        <th>ROBEK KAPAL</th>
        <th>BASAH PBM</th>
        <th>ROBEK PBM</th>
        <th>BASAH TRUCK</th>
        <th>ROBEK TRUCK</th>
        <th>KARUNG LEBIH</th>
        <th>KARUNG KURANG</th>
        <th>TOTAL ITEM (tanpa Karung Kurang)</th>
    </tr>
    <tr>
        <td>{{ $summaryData['utuh'] ?? 0 }}</td>
        <td>{{ $summaryData['basah_kapal'] ?? 0 }}</td>
        <td>{{ $summaryData['robek_kapal'] ?? 0 }}</td>
        <td>{{ $summaryData['basah_pbm'] ?? 0 }}</td>
        <td>{{ $summaryData['robek_pbm'] ?? 0 }}</td>
        <td>{{ $summaryData['basah_truck'] ?? 0 }}</td>
        <td>{{ $summaryData['robek_truck'] ?? 0 }}</td>
        <td>{{ $summaryData['karung_lebih'] ?? 0 }}</td>
        <td>{{ $summaryData['karung_kurang'] ?? 0 }}</td>
        <td>{{ $summaryData['total_item'] ?? 0 }}</td>
    </tr>
</table>
