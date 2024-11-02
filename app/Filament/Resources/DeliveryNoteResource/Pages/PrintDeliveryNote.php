<?php

namespace App\Filament\Resources\DeliveryNoteResource\Pages;

use App\Filament\Resources\DeliveryNoteResource;
use Filament\Resources\Pages\Page;
use Filament\Actions;
use App\Models\DeliveryNote;

class PrintDeliveryNote extends Page
{
    protected static string $resource = DeliveryNoteResource::class;

    protected static string $view = 'filament.resources.delivery-note-resource.pages.print-delivery-note';

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
                ->label('Print Surat Jalan')
                ->color('info')
                ->icon('heroicon-o-printer')
                ->action('printDeliveryNote'),
        ];
    }

    public function printDeliveryNote()
    {
        // Update print status
        $this->record->update(['print' => true]);

        // Trigger print dialog via JavaScript
        $this->dispatch('print-delivery-note');
    }

    // Ubah protected menjadi public
    public function getTitle(): string
    {
        return "Print Surat Jalan: {$this->record->nomor_surat}";
    }
}
