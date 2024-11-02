<?php

namespace App\Filament\Warehouse\Resources\DeliveryNoteResource\Pages;

use App\Filament\Warehouse\Resources\DeliveryNoteResource;
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
