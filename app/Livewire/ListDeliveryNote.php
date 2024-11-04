<?php

namespace App\Livewire;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use App\Models\DeliveryNote;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;


class ListDeliveryNote extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $start_date;
    public $end_date;
    public $status = [];
    public $ship_to = [];
    public $isFiltered = false; // Menandakan apakah filter sudah diterapkan

    public function table(Table $table): Table
    {
        return $table
            ->query(function (Builder $query): Builder {
                // Jika filter belum diterapkan, kembalikan query kosong
                if (!$this->isFiltered) {
                    return DeliveryNote::query()->whereRaw('1 = 0'); // Tidak menampilkan data
                }

                // Jika filter sudah diterapkan, jalankan query dengan filter
                return DeliveryNote::query()
                    ->when(
                        $this->start_date,
                        fn($q) => $q->whereDate('created_at', '>=', $this->start_date)
                    )
                    ->when(
                        $this->end_date,
                        fn($q) => $q->whereDate('created_at', '<=', $this->end_date)
                    )
                    ->when(
                        !empty($this->status),
                        fn($q) => $q->whereIn('status', $this->status)
                    )
                    ->when(
                        !empty($this->ship_to),
                        fn($q) => $q->whereIn('ship_to', $this->ship_to)
                    );
            })
            ->poll('60s')
            ->deferLoading() // Menunda pemuatan data hingga filter diterapkan
            ->defaultSort('created_at', 'desc')
            ->heading('Laporan Surat Jalan')
            ->description('Tabel ini menampilkan informasi surat jalan pengiriman barang. Data dapat diunduh dalam format Excel atau PDF.')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No.'),
                // Informasi Dasar
                Tables\Columns\ColumnGroup::make('Informasi Dasar', [
                    Tables\Columns\TextColumn::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->weight('bold'),

                    Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'dibuat' => 'gray',
                            'dikirim' => 'warning',
                            'sampai' => 'info',
                            'selesai' => 'success',
                        })
                        ->icon(fn(string $state): string => match ($state) {
                            'dibuat' => 'heroicon-o-pencil',
                            'dikirim' => 'heroicon-o-truck',
                            'sampai' => 'heroicon-o-check-circle',
                            'selesai' => 'heroicon-o-flag',
                            default => 'heroicon-o-question-mark-circle'
                        }),

                    Tables\Columns\IconColumn::make('print')
                        ->label('Dicetak')
                        ->boolean()
                        ->trueIcon('heroicon-o-check-circle')
                        ->falseIcon('heroicon-o-x-circle')
                        ->trueColor('success')
                        ->falseColor('danger'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Klien
                Tables\Columns\ColumnGroup::make('Informasi Klien', [
                    Tables\Columns\TextColumn::make('client.user.name')
                        ->label('Nama PIC'),

                    Tables\Columns\TextColumn::make('client.company_name')
                        ->label('Perusahaan PIC'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Petugas
                Tables\Columns\ColumnGroup::make('Informasi Petugas', [
                    Tables\Columns\TextColumn::make('fieldOfficer.user.name')
                        ->label('Petugas Lapangan'),

                    Tables\Columns\TextColumn::make('roomOfficer.user.name')
                        ->label('Petugas Ruangan'),

                    Tables\Columns\TextColumn::make('warehouseOfficer.user.name')
                        ->label('Petugas Gudang'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Pengiriman
                Tables\Columns\ColumnGroup::make('Informasi Pengiriman', [
                    Tables\Columns\TextColumn::make('ship_to')
                        ->label('Tujuan')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'gudang kota' => 'success',
                            'gudang unaaha' => 'warning',
                            'gudang kolaka' => 'danger',
                        }),

                    Tables\Columns\TextColumn::make('nama_driver')
                        ->label('Supir'),

                    Tables\Columns\TextColumn::make('nomor_plat')
                        ->label('Plat'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Item
                Tables\Columns\ColumnGroup::make('Informasi Item', [
                    Tables\Columns\TextColumn::make('items.name_item')
                        ->label('Nama Item')
                        ->listWithLineBreaks()
                        ->bulleted(),

                    Tables\Columns\TextColumn::make('items.quantity')
                        ->label('Jumlah')
                        ->listWithLineBreaks(),

                    Tables\Columns\TextColumn::make('items.description')
                        ->label('Kondisi')
                        ->listWithLineBreaks(),

                    Tables\Columns\TextColumn::make('items_sum_quantity')
                        ->label('Jumlah Item')
                        ->getStateUsing(function (DeliveryNote $record) {
                            $total = 0;
                            foreach ($record->items as $item) {
                                if ($item->description === 'karung kurang') {
                                    $total -= $item->quantity;
                                } else {
                                    $total += $item->quantity;
                                }
                            }
                            return $total;
                        })
                        ->badge()
                        ->color('info'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),

                // Informasi Tanggal Dan Waktu
                Tables\Columns\ColumnGroup::make('Informasi Tanggal Dan Waktu', [
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Tgl. Dibuat')
                        ->dateTime('d M Y H:i')
                        ->color('secondary'),

                    Tables\Columns\TextColumn::make('tanggal_pengiriman')
                        ->label('Tgl. Dikirim')
                        ->color('warning')
                        ->date('d M Y H:i'),

                    Tables\Columns\TextColumn::make('tanggal_sampai')
                        ->label('Tgl. Sampai')
                        ->color('info')
                        ->date('d M Y H:i'),

                    Tables\Columns\TextColumn::make('tanggal_bongkar')
                        ->label('Tgl. Selesai')
                        ->color('success')
                        ->date('d M Y H:i'),

                    Tables\Columns\TextColumn::make('updated_at')
                        ->label('Tgl. Update')
                        ->dateTime('d M Y H:i'),
                ])
                    ->alignment(Alignment::Center)
                    ->wrapHeader(),
            ])
            ->emptyStateHeading('Tidak Ada Data Laporan Surat Jalan')
            ->emptyStateDescription('Gunakan filter untuk menampilkan laporan surat jalan yang diinginkan')
            ->emptyStateIcon('heroicon-o-document-magnifying-glass')
            ->striped()
            ->paginated(false);
    }

    #[On('filter-changed')]
    public function applyFilter($filter)
    {
        $this->start_date = $filter['start_date'];
        $this->end_date = $filter['end_date'];
        $this->status = $filter['status'];
        $this->ship_to = $filter['ship_to'];
        $this->isFiltered = true; // Menandakan bahwa filter telah diterapkan
    }

    #[On('reset-filter')] // Mendengarkan event reset filter
    public function resetFilter()
    {
        $this->start_date = null;
        $this->end_date = null;
        $this->status = [];
        $this->ship_to = [];
        $this->isFiltered = false; // Set isFiltered ke false saat filter di-reset
    }

    public function render()
    {
        return view('livewire.list-delivery-note');
    }
}
