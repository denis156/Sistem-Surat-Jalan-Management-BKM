<?php

namespace App\Livewire;

use App\Models\DeliveryNote;
use App\Models\Item;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Livewire\Component;
use Livewire\Attributes\On;

class SummaryDeliveryNote extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public $start_date;
    public $end_date;
    public $status = [];
    public $ship_to = [];
    public $isFiltered = false; // Menandai apakah filter telah diterapkan

    public function deliveryNoteInfolist(Infolist $infolist): Infolist
    {
        $query = DeliveryNote::query()
            ->when($this->isFiltered && $this->start_date, fn($q) => $q->whereDate('created_at', '>=', $this->start_date))
            ->when($this->isFiltered && $this->end_date, fn($q) => $q->whereDate('created_at', '<=', $this->end_date))
            ->when($this->isFiltered && !empty($this->status), fn($q) => $q->whereIn('status', $this->status))
            ->when($this->isFiltered && !empty($this->ship_to), fn($q) => $q->whereIn('ship_to', $this->ship_to));

        $itemQuery = Item::query()->whereHas('deliveryNote', function ($q) {
            $q->when($this->isFiltered && $this->start_date, fn($q) => $q->whereDate('created_at', '>=', $this->start_date))
                ->when($this->isFiltered && $this->end_date, fn($q) => $q->whereDate('created_at', '<=', $this->end_date))
                ->when($this->isFiltered && !empty($this->status), fn($q) => $q->whereIn('status', $this->status))
                ->when($this->isFiltered && !empty($this->ship_to), fn($q) => $q->whereIn('ship_to', $this->ship_to));
        });

        $data = [
            'jumlah_gudang_kota' => $this->isFiltered ? (clone $query)->where('ship_to', 'gudang kota')->count() : 0,
            'jumlah_gudang_unaaha' => $this->isFiltered ? (clone $query)->where('ship_to', 'gudang unaaha')->count() : 0,
            'jumlah_gudang_kolaka' => $this->isFiltered ? (clone $query)->where('ship_to', 'gudang kolaka')->count() : 0,
            'total_surat_jalan' => $this->isFiltered ? $query->count() : 0,
            'utuh' => $this->isFiltered ? (clone $itemQuery)->where('description', 'utuh')->sum('quantity') : 0,
            'basah_kapal' => $this->isFiltered ? (clone $itemQuery)->where('description', 'basah kapal')->sum('quantity') : 0,
            'robek_kapal' => $this->isFiltered ? (clone $itemQuery)->where('description', 'robek kapal')->sum('quantity') : 0,
            'basah_pbm' => $this->isFiltered ? (clone $itemQuery)->where('description', 'basah pbm')->sum('quantity') : 0,
            'robek_pbm' => $this->isFiltered ? (clone $itemQuery)->where('description', 'robek pbm')->sum('quantity') : 0,
            'basah_truck' => $this->isFiltered ? (clone $itemQuery)->where('description', 'basah truck')->sum('quantity') : 0,
            'robek_truck' => $this->isFiltered ? (clone $itemQuery)->where('description', 'robek truck')->sum('quantity') : 0,
            'karung_lebih' => $this->isFiltered ? (clone $itemQuery)->where('description', 'karung lebih')->sum('quantity') : 0,
            'karung_kurang' => $this->isFiltered ? (clone $itemQuery)->where('description', 'karung kurang')->sum('quantity') : 0,
            'total_item' => $this->isFiltered ? $itemQuery->where('description', '!=', 'karung kurang')->sum('quantity') : 0,
        ];

        return $infolist
            ->state($data)
            ->schema([
                Grid::make(2)
                    ->schema([
                        // Bagian Informasi Gudang
                        Section::make('Informasi Gudang')
                            ->description('Ringkasan jumlah surat jalan per gudang')
                            ->schema([
                                TextEntry::make('jumlah_gudang_kota')
                                    ->label('Gudang Kota')
                                    ->size('xl')
                                    ->weight('bold'),
                                TextEntry::make('jumlah_gudang_unaaha')
                                    ->label('Gudang Unaaha')
                                    ->size('xl')
                                    ->weight('bold'),
                                TextEntry::make('jumlah_gudang_kolaka')->label('Gudang Kolaka')
                                    ->size('xl')
                                    ->weight('bold'),
                                TextEntry::make('total_surat_jalan')
                                    ->label('Total Surat Jalan')
                                    ->size('lg')
                                    ->weight('bold')
                                    ->color('success'),
                            ])
                            ->columns(4),

                        // Bagian Kondisi Barang
                        Section::make('Kondisi Barang')
                            ->description('Detail kondisi barang berdasarkan kategori')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Section::make('Kapal')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('basah_kapal')
                                                            ->label('Basah')
                                                            ->color('danger')
                                                            ->size('xl'),
                                                        TextEntry::make('robek_kapal')
                                                            ->label('Robek')
                                                            ->color('danger')
                                                            ->size('xl'),
                                                    ]),
                                            ])
                                            ->collapsible(),

                                        Section::make('PBM')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('basah_pbm')
                                                            ->label('Basah')
                                                            ->color('danger')
                                                            ->size('xl'),
                                                        TextEntry::make('robek_pbm')
                                                            ->label('Robek')
                                                            ->color('danger')
                                                            ->size('xl'),
                                                    ]),
                                            ])
                                            ->collapsible(),

                                        Section::make('Truck')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('basah_truck')
                                                            ->label('Basah')
                                                            ->color('danger')
                                                            ->size('xl'),
                                                        TextEntry::make('robek_truck')
                                                            ->label('Robek')
                                                            ->color('danger')
                                                            ->size('xl'),
                                                    ]),
                                            ])
                                            ->collapsible(),
                                    ]),
                            ]),
                    ]),

                // Bagian Ringkasan Total
                Section::make('Ringkasan Total')
                    ->description('Ringkasan jumlah karung dan total item')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('utuh')
                            ->label('Utuh')
                            ->color('success')
                            ->size('xl'),
                        TextEntry::make('karung_lebih')
                            ->label('Karung Lebih')
                            ->color('info')
                            ->size('xl'),
                        TextEntry::make('karung_kurang')
                            ->label('Karung Kurang')
                            ->color('danger')
                            ->size('xl'),
                        TextEntry::make('total_item')
                            ->label('Total Item (tanpa Karung Kurang)')
                            ->color('primary')
                            ->size('lg')
                            ->weight('bold'),
                    ]),
            ]);
    }

    #[On('filter-changed')]
    public function applyFilter($filter)
    {
        $this->start_date = $filter['start_date'];
        $this->end_date = $filter['end_date'];
        $this->status = $filter['status'];
        $this->ship_to = $filter['ship_to'];
        $this->isFiltered = true; // Menandai bahwa filter telah diterapkan
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
        return view('livewire.summary-delivery-note');
    }
}
