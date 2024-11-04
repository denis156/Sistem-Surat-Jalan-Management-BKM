<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use App\Models\Item;
use Filament\Actions;
use Filament\Pages\Page;
use App\Models\DeliveryNote;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\ActionGroup;
use App\Exports\DeliveryNoteExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;

class LaporanSuratJalan extends Page
{
    protected static string $view = 'filament.pages.laporan-surat-jalan';

    public $start_date;
    public $end_date;
    public $status;
    public $ship_to;
    public $isFiltered = false;

    protected function getHeaderActions(): array
    {
        return [
            //ActionGroup Filter data Laporan surat jalan
            ActionGroup::make([
                Actions\Action::make('filter')
                    ->label('Filter Data Laporan')
                    ->size(ActionSize::Large)
                    ->color('info')
                    ->icon('heroicon-o-magnifying-glass-plus')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->native(false)
                            ->default(now()->startOfMonth()),
                        DatePicker::make('end_date')
                            ->label('Tanggal Akhir')
                            ->native(false)
                            ->default(now()),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'dibuat' => 'Dibuat',
                                'dikirim' => 'Dikirim',
                                'sampai' => 'Sampai',
                                'selesai' => 'Selesai',
                            ])
                            ->placeholder('Semua Status')
                            ->multiple(),
                        Select::make('ship_to')
                            ->label('Tujuan')
                            ->options([
                                'gudang kota' => 'Gudang Kota',
                                'gudang unaaha' => 'Gudang Unaaha',
                                'gudang kolaka' => 'Gudang Kolaka',
                            ])
                            ->placeholder('Semua Tujuan')
                            ->multiple(),
                    ])
                    ->action(function (array $data) {
                        $this->start_date = $data['start_date'] ? Carbon::parse($data['start_date']) : null;
                        $this->end_date = $data['end_date'] ? Carbon::parse($data['end_date']) : null;
                        $this->status = $data['status'] ?? [];
                        $this->ship_to = $data['ship_to'] ?? [];
                        $this->isFiltered = true;

                        $this->dispatch('filter-changed', [
                            'start_date' => $this->start_date,
                            'end_date' => $this->end_date,
                            'status' => $this->status,
                            'ship_to' => $this->ship_to,
                        ]);

                        // Menyusun detail filter untuk notifikasi
                        $statusText = !empty($this->status) ? implode(', ', $this->status) : 'Semua Status';
                        $shipToText = !empty($this->ship_to) ? implode(', ', $this->ship_to) : 'Semua Tujuan';
                        $dateText = ($this->start_date ? $this->start_date->format('d M Y') : 'Awal') . ' Sampai ' .
                            ($this->end_date ? $this->end_date->format('d M Y') : 'Akhir');

                        Notification::make()
                            ->title('Filter Diterapkan')
                            ->body("Tanggal: {$dateText}\nStatus: {$statusText}\nTujuan: {$shipToText}")
                            ->success()
                            ->send();
                    }),


                Actions\Action::make('resetFilter')
                    ->label('Reset Filter Laporan')
                    ->size(ActionSize::Large)
                    ->color('secondary')
                    ->icon('heroicon-o-magnifying-glass-minus')
                    ->action(function () {
                        // Cek apakah ada filter yang aktif
                        if (is_null($this->start_date) && is_null($this->end_date) && empty($this->status) && empty($this->ship_to)) {
                            // Jika tidak ada filter yang aktif, tampilkan notifikasi
                            Notification::make()
                                ->title('Tidak Ada Filter yang Direset')
                                ->body('Saat ini tidak ada filter yang aktif untuk direset.')
                                ->warning()
                                ->send();
                        } else {
                            // Reset filter jika ada yang aktif
                            $this->start_date = null;
                            $this->end_date = null;
                            $this->status = [];
                            $this->ship_to = [];
                            $this->isFiltered = false;

                            $this->dispatch('reset-filter');

                            Notification::make()
                                ->title('Filter Direset')
                                ->body('Semua filter telah direset. Data akan ditampilkan tanpa filter.')
                                ->info()
                                ->send();
                        }
                    }),
            ])
                ->label('Filter Laporan')
                ->icon('heroicon-o-funnel')
                ->size(ActionSize::Large)
                ->color('primary')
                ->button(),

            //ActionGroup Download data Laporan surat jalan
            ActionGroup::make([
                Actions\Action::make('pdf')
                    ->label('Download Laporan PDF')
                    ->color('danger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function () {
                        // Cek apakah filter telah diterapkan
                        if (!$this->isFiltered) {
                            Notification::make()
                                ->title('Filter diperlukan')
                                ->body('Silakan pilih filter sebelum mendownload laporan PDF.')
                                ->warning()
                                ->send();

                            return;
                        }

                        // Query untuk mengambil data yang sesuai dengan filter
                        $query = DeliveryNote::query()
                            ->when($this->start_date, fn($q) => $q->whereDate('created_at', '>=', $this->start_date))
                            ->when($this->end_date, fn($q) => $q->whereDate('created_at', '<=', $this->end_date))
                            ->when(!empty($this->status), fn($q) => $q->whereIn('status', $this->status))
                            ->when(!empty($this->ship_to), fn($q) => $q->whereIn('ship_to', $this->ship_to));

                        // Data untuk Summary sesuai filter
                        $summaryData = [
                            'jumlah_gudang_kota' => (clone $query)->where('ship_to', 'gudang kota')->count(),
                            'jumlah_gudang_unaaha' => (clone $query)->where('ship_to', 'gudang unaaha')->count(),
                            'jumlah_gudang_kolaka' => (clone $query)->where('ship_to', 'gudang kolaka')->count(),
                            'total_surat_jalan' => $query->count(),
                            'utuh' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'utuh')->sum('quantity'),
                            'basah_kapal' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'basah kapal')->sum('quantity'),
                            'robek_kapal' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'robek kapal')->sum('quantity'),
                            'basah_pbm' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'basah pbm')->sum('quantity'),
                            'robek_pbm' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'robek pbm')->sum('quantity'),
                            'basah_truck' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'basah truck')->sum('quantity'),
                            'robek_truck' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'robek truck')->sum('quantity'),
                            'karung_lebih' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'karung lebih')->sum('quantity'),
                            'karung_kurang' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'karung kurang')->sum('quantity'),
                            'total_item' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', '!=', 'karung kurang')->sum('quantity'),
                        ];

                        // Data untuk Tabel
                        $deliveryNotes = $query->with([
                            'client.user',
                            'fieldOfficer.user',
                            'roomOfficer.user',
                            'warehouseOfficer.user',
                            'items'
                        ])->orderBy('created_at', 'desc')->get();

                        // Generate string untuk tanggal, status, dan tujuan pada notifikasi dan nama file
                        $dateText = ($this->start_date ? Carbon::parse($this->start_date)->format('d M Y') : 'Awal') . ' - ' .
                            ($this->end_date ? Carbon::parse($this->end_date)->format('d M Y') : 'Akhir');
                        $statusText = !empty($this->status) ? implode(', ', $this->status) : 'Semua Status';
                        $shipToText = !empty($this->ship_to) ? implode(', ', $this->ship_to) : 'Semua Tujuan';

                        // Generate nama file sesuai filter
                        $fileName = 'Laporan Surat Jalan (' . $dateText . ') ' . ($statusText !== 'Semua Status' ? 'Status ' . $statusText : '') . ' ' . ($shipToText !== 'Semua Tujuan' ? 'Tujuan ' . $shipToText : '') . '.pdf';

                        // Generate PDF
                        $pdf = Pdf::loadView('report.pdf.laporan-surat-jalan-pdf', [
                            'summaryData' => $summaryData,
                            'deliveryNotes' => $deliveryNotes,
                            'tanggal' => $dateText,
                            'filter' => [
                                'start_date' => $this->start_date,
                                'end_date' => $this->end_date,
                                'status' => $this->status,
                                'ship_to' => $this->ship_to,
                            ],
                        ]);

                        // Set paper ke landscape dan options
                        $pdf->setPaper('a4', 'landscape')
                            ->setOption([
                                'dpi' => 150,
                                'defaultFont' => 'sans-serif',
                                'isRemoteEnabled' => true,
                                'isHtml5ParserEnabled' => true,
                                'isPhpEnabled' => true,
                                'margin_top' => 10,
                                'margin_bottom' => 10,
                                'margin_left' => 10,
                                'margin_right' => 10,
                            ]);

                        // Return file PDF untuk di-download
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, $fileName);

                        // Notifikasi unduhan berhasil
                        Notification::make()
                            ->title('Unduhan Berhasil')
                            ->body('Laporan Surat Jalan berhasil diunduh dengan filter: Tanggal: ' . $dateText . ', Status: ' . $statusText . ', Tujuan: ' . $shipToText)
                            ->success()
                            ->send();
                    }),

                Actions\Action::make('excel')
                    ->label('Download Laporan Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        // Cek apakah filter telah diterapkan
                        if (!$this->isFiltered) {
                            Notification::make()
                                ->title('Filter diperlukan')
                                ->body('Silakan pilih filter sebelum mendownload laporan Excel.')
                                ->warning()
                                ->send();

                            return;
                        }

                        // Query untuk mengambil data yang sesuai dengan filter
                        $query = DeliveryNote::query()
                            ->when($this->start_date, fn($q) => $q->whereDate('created_at', '>=', $this->start_date))
                            ->when($this->end_date, fn($q) => $q->whereDate('created_at', '<=', $this->end_date))
                            ->when(!empty($this->status), fn($q) => $q->whereIn('status', $this->status))
                            ->when(!empty($this->ship_to), fn($q) => $q->whereIn('ship_to', $this->ship_to));

                        // Data untuk Summary
                        $summaryData = [
                            'jumlah_gudang_kota' => (clone $query)->where('ship_to', 'gudang kota')->count(),
                            'jumlah_gudang_unaaha' => (clone $query)->where('ship_to', 'gudang unaaha')->count(),
                            'jumlah_gudang_kolaka' => (clone $query)->where('ship_to', 'gudang kolaka')->count(),
                            'total_surat_jalan' => $query->count(),
                            'utuh' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'utuh')->sum('quantity'),
                            'basah_kapal' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'basah kapal')->sum('quantity'),
                            'robek_kapal' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'robek kapal')->sum('quantity'),
                            'basah_pbm' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'basah pbm')->sum('quantity'),
                            'robek_pbm' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'robek pbm')->sum('quantity'),
                            'basah_truck' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'basah truck')->sum('quantity'),
                            'robek_truck' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'robek truck')->sum('quantity'),
                            'karung_lebih' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'karung lebih')->sum('quantity'),
                            'karung_kurang' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', 'karung kurang')->sum('quantity'),
                            'total_item' => Item::whereHas('deliveryNote', fn($q) => $q->whereIn('id', $query->pluck('id')))->where('description', '!=', 'karung kurang')->sum('quantity'),
                        ];

                        // Data untuk Tabel
                        $deliveryNotes = $query->with([
                            'client.user',
                            'fieldOfficer.user',
                            'roomOfficer.user',
                            'warehouseOfficer.user',
                            'items'
                        ])->orderBy('created_at', 'desc')->get();

                        // Generate string untuk nama file
                        $dateText = ($this->start_date ? Carbon::parse($this->start_date)->format('d M Y') : 'Awal') . ' - ' .
                            ($this->end_date ? Carbon::parse($this->end_date)->format('d M Y') : 'Akhir');
                        $statusText = !empty($this->status) ? implode(', ', $this->status) : 'Semua Status';
                        $shipToText = !empty($this->ship_to) ? implode(', ', $this->ship_to) : 'Semua Tujuan';

                        $fileName = 'Laporan Surat Jalan (' . $dateText . ') ' . ($statusText !== 'Semua Status' ? 'Status ' . $statusText : '') . ' ' . ($shipToText !== 'Semua Tujuan' ? 'Tujuan ' . $shipToText : '') . '.xlsx';

                        // Generate Excel menggunakan package maatwebsite/excel
                        return Excel::download(new DeliveryNoteExport([
                            'deliveryNotes' => $deliveryNotes,
                            'summaryData' => $summaryData,
                            'filter' => [
                                'start_date' => $this->start_date,
                                'end_date' => $this->end_date,
                                'status' => $this->status,
                                'ship_to' => $this->ship_to,
                            ],
                        ]), $fileName);
                    }),
            ])
                ->label('Download Laporan')
                ->icon('heroicon-o-arrow-down-tray')
                ->size(ActionSize::Large)
                ->color('primary')
                ->button()
        ];
    }
}
