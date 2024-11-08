<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('secondary')
                ->icon('heroicon-o-arrow-left'),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->color('danger')
                ->icon('heroicon-o-trash'),
            Actions\ForceDeleteAction::make()
                ->label('Hapus Permanen')
                ->color('danger')
                ->icon('heroicon-o-trash'),
            Actions\RestoreAction::make()
                ->label('Pulihkan')
                ->color('warning')
                ->icon('heroicon-o-arrow-path'),
        ];
    }
}
