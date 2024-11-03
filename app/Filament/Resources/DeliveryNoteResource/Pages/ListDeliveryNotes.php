<?php

namespace App\Filament\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use App\Models\DeliveryNote;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DeliveryNoteResource;

class ListDeliveryNotes extends ListRecords
{
    protected static string $resource = DeliveryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Surat Jalan')
                ->color('primary')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->label('Semua')
                ->badge(DeliveryNote::count()),

            'dibuat' => Tab::make('Dibuat')
                ->label('Dibuat')
                ->icon('heroicon-o-pencil')
                ->badge(DeliveryNote::where('status', 'dibuat')->count())
                ->badgeColor('secondary')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'dibuat')),

            'dikirim' => Tab::make('Dikirim')
                ->label('Dikirim')
                ->icon('heroicon-o-truck')
                ->badge(DeliveryNote::where('status', 'dikirim')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'dikirim')),

            'sampai' => Tab::make('Sampai')
                ->label('Sampai')
                ->icon('heroicon-o-check-circle')
                ->badge(DeliveryNote::where('status', 'sampai')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'sampai')),

            'selesai' => Tab::make('Selesai')
                ->label('Selesai')
                ->icon('heroicon-o-flag')
                ->badge(DeliveryNote::where('status', 'selesai')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'selesai')),
        ];
    }
}
