<?php

namespace App\Filament\Client\Resources\DeliveryNoteResource\Pages;

use App\Filament\Client\Resources\DeliveryNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryNote extends EditRecord
{
    protected static string $resource = DeliveryNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
