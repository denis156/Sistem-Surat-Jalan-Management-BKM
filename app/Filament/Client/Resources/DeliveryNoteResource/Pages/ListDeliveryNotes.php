<?php

namespace App\Filament\Client\Resources\DeliveryNoteResource\Pages;

use App\Filament\Client\Resources\DeliveryNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryNotes extends ListRecords
{
    protected static string $resource = DeliveryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
