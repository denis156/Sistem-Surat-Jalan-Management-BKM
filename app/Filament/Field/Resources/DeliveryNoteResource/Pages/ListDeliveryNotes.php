<?php

namespace App\Filament\Field\Resources\DeliveryNoteResource\Pages;

use App\Filament\Field\Resources\DeliveryNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

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
}