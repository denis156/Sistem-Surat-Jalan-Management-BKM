<?php

namespace App\Filament\Warehouse\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Warehouse\Resources\DeliveryNoteResource;

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
        ];
    }

    /**
     * Ensure that the record cannot be edited if its status is "selesai".
     */
    protected function ensureEditableStatus(): void
    {
        // Cegah pengeditan jika status adalah "selesai"
        if ($this->record->status === 'selesai') {
            // Kirim notifikasi ke pengguna
            Notification::make()
                ->title('Tidak dapat mengedit')
                ->body('Surat jalan ini tidak bisa diedit karena statusnya sudah "selesai".')
                ->danger()
                ->persistent()
                ->duration(5000)
                ->send();

            // Redirect ke halaman daftar
            $this->redirectRoute('filament.warehouse.resources.Penerimaan-Surat-Jalan.index');
        }
    }
}
