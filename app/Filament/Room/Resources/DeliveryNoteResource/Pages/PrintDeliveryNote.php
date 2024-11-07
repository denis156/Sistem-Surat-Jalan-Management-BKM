<?php

namespace App\Filament\Room\Resources\DeliveryNoteResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use App\Filament\Room\Resources\DeliveryNoteResource;
use App\Models\DeliveryNote;

class PrintDeliveryNote extends Page
{
    protected static string $resource = DeliveryNoteResource::class;
    protected static string $view = 'filament.room.resources.delivery-note-resource.pages.print-delivery-note';

    public DeliveryNote $record;

    public function mount(DeliveryNote $record): void
    {
        $this->record = $record->load([
            'client.user',
            'fieldOfficer.user',
            'roomOfficer.user',
            'warehouseOfficer.user',
            'items'
        ]);

        // Pastikan hanya dapat diakses jika statusnya masih "dikirim" atau "dibuat"
        $this->ensureEditableStatus();
    }

    protected function beforeFill(): void
    {
        $this->ensureEditableStatus();
    }

    /**
     * Ensure that the record can be accessed only if the status is "dibuat" or "dikirim"
     * and if the logged officer is the correct officer for the record.
     */
    protected function ensureEditableStatus(): void
    {
        // Ambil ID officer yang sedang login
        $loggedOfficerId = auth()->user()->officer->id ?? null;

        // Jika officer yang mencoba mengakses bukan field_officer yang benar
        if ($this->record->room_officer_id && $this->record->room_officer_id !== $loggedOfficerId) {
            $officerName = $this->record->roomOfficer->user->name ?? 'Officer Tidak Diketahui';
            Notification::make()
                ->title('Surat Jalan Sudah Dicetak')
                ->body("Surat Jalan nomor {$this->record->nomor_surat} telah dicetak oleh $officerName.")
                ->danger()
                ->persistent()
                ->duration(3000)
                ->send();

            // Redirect ke halaman daftar
            $this->redirectRoute('filament.room.resources.Surat-Jalan.index');
        }

        // Jika status bukan "dibuat" atau "dikirim"
        elseif (!in_array($this->record->status, ['dibuat', 'dikirim'])) {
            Notification::make()
                ->title('Tidak Dapat Mengakses')
                ->body('Surat jalan ini tidak bisa diakses karena statusnya bukan "dibuat" atau "dikirim".')
                ->danger()
                ->persistent()
                ->duration(3000)
                ->send();

            // Redirect ke halaman daftar
            $this->redirectRoute('filament.room.resources.Surat-Jalan.index');
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('secondary')
                ->icon('heroicon-o-arrow-left'),

            Actions\Action::make('edit')
                ->label('Edit')
                ->url(fn() => $this->getResource()::getUrl('edit', ['record' => $this->record->getKey()]))
                ->color('success')
                ->icon('heroicon-o-pencil'),

            Actions\Action::make('print')
                ->label('Cetak Surat Jalan')
                ->color($this->record->print ? 'warning' : 'info')  // Warna berubah menjadi warning jika print sudah true
                ->icon('heroicon-o-printer')
                ->requiresConfirmation()
                ->modalHeading($this->record->print ? 'Konfirmasi Cetak Ulang' : 'Konfirmasi Cetak')
                ->modalDescription($this->record->print
                    ? 'Surat jalan ini sudah pernah kamu cetak. Apakah Anda yakin ingin mencetak ulang surat jalan ini?'
                    : 'Apakah Anda yakin ingin mencetak surat jalan ini?')
                ->modalSubmitActionLabel('Ya, Cetak')
                ->action(function () {
                    $this->printDeliveryNote();
                }),
        ];
    }

    public function printDeliveryNote()
    {
        // Cek apakah client dan warehouse officer sudah diisi
        if (is_null($this->record->client_id) || is_null($this->record->warehouse_officer_id)) {
            // Jika belum ada, tampilkan notifikasi untuk mengisi terlebih dahulu
            Notification::make()
                ->title('Data Tidak Lengkap')
                ->body('Silakan lengkapi data klien dan petugas gudang sebelum mencetak surat jalan.')
                ->danger()
                ->persistent()
                ->duration(3000)
                ->send();

            return; // Hentikan proses jika data belum lengkap
        }

        // Ambil ID officer room yang sedang login
        $roomOfficerId = auth()->user()->officer->id ?? null;

        if ($roomOfficerId) {
            // Update status menjadi 'dikirim', set tanggal pengiriman, tandai sudah dicetak, dan isi room_officer_id
            $this->record->update([
                'room_officer_id' => $roomOfficerId,
                'status' => 'dikirim',
                'tanggal_pengiriman' => now(),
                'print' => true,
            ]);

            // Kirim notifikasi berhasil
            Notification::make()
                ->title('Surat Jalan Berhasil Dicetak')
                ->body("Surat jalan nomor {$this->record->nomor_surat} berhasil dicetak.")
                ->success()
                ->send();
        }

        // Trigger print dialog via JavaScript
        $this->dispatch('print-delivery-note');
    }

    public function getTitle(): string
    {
        return "Print Surat Jalan: {$this->record->nomor_surat}";
    }
}
