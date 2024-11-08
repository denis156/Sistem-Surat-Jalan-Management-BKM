<?php

namespace App\Filament\Field\Resources\DeliveryNoteResource\Pages;

use App\Filament\Field\Resources\DeliveryNoteResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryNote extends EditRecord
{
    protected static string $resource = DeliveryNoteResource::class;

    protected function beforeFill(): void
    {
        $this->ensureEditableStatus();
    }

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

    /**
     * Ensure that the record can be edited only if its status is "dibuat".
     */
    protected function ensureEditableStatus(): void
    {
        if ($this->record->status !== 'dibuat') {
            // Kirim notifikasi ke pengguna
            Notification::make()
                ->title('Tidak dapat mengedit')
                ->body('Surat jalan ini tidak bisa diedit karena statusnya bukan "dibuat".')
                ->danger()
                ->persistent()
                ->duration(3000)
                ->send();

            // Redirect ke halaman daftar
            $this->redirectRoute('filament.field.resources.Surat-Jalan.index');
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record->getKey()]);
    }
}
