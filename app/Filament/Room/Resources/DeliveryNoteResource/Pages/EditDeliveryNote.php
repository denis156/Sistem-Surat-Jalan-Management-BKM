<?php

namespace App\Filament\Room\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use App\Models\DeliveryNote;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Room\Resources\DeliveryNoteResource;

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
            Actions\Action::make('print')
                ->label('Cetak')
                ->url(fn(DeliveryNote $record) => route('filament.room.resources.Surat-Jalan.print', $record))
                ->color('info')
                ->icon('heroicon-o-printer'),
        ];
    }

    /**
     * Ensure that the record can be edited only if its status is "dikirim" or "dibuat".
     */
    protected function ensureEditableStatus(): void
    {
        $loggedOfficerId = Auth::user()->officer->id ?? null;

        // Cek jika officer lain sudah mencetak surat jalan atau mengubah status
        if ($this->record->room_officer_id && $this->record->room_officer_id !== $loggedOfficerId) {
            $officerName = $this->record->roomOfficer->user->name ?? 'Officer Tidak Diketahui';
            Notification::make()
                ->title('Akses Ditolak')
                ->body("Surat jalan ini sudah ditangani oleh $officerName dan tidak dapat diedit.")
                ->warning()
                ->persistent()
                ->send();

            $this->redirectRoute('filament.room.resources.Surat-Jalan.index');
            return;
        }

        // Cek jika status bukan "dikirim" atau "dibuat"
        if (!in_array($this->record->status, ['dikirim', 'dibuat'])) {
            Notification::make()
                ->title('Tidak dapat mengedit')
                ->body('Surat jalan ini tidak bisa diedit karena statusnya bukan "dikirim" atau "dibuat".')
                ->danger()
                ->persistent()
                ->send();

            $this->redirectRoute('filament.room.resources.Surat-Jalan.index');
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('print', ['record' => $this->record->getKey()]);
    }
}
