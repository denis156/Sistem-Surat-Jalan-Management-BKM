<?php

namespace App\Filament\Field\Resources\DeliveryNoteResource\Pages;

use App\Filament\Field\Resources\DeliveryNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeliveryNote extends CreateRecord
{
    protected static string $resource = DeliveryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('secondary')
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}
